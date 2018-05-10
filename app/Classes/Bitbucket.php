<?php

namespace GitScrum\Classes;

use Auth;
use Carbon\Carbon;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use GitScrum\Models\Branch;
use GitScrum\Contracts\ProviderInterface;
use GuzzleHttp\Client as GuzzleClient;

class Bitbucket implements ProviderInterface
{
    private const API_URL = 'https://api.bitbucket.org/';
    private const API_VER = '2.0/';

    public function tplUser($obj)
    {
        return [
            'provider_id' => $obj->id,
            'provider' => 'bitbucket',
            'username' => $obj->nickname,
            'name' => $obj->name,
            'token' => $obj->token,
            'refresh_token' => $obj->refreshToken,
            'avatar' => $obj->avatar,
            'html_url' => $obj->user['links']['html']['href'],
            'since' => Carbon::parse($obj->user['created_on'])->toDateTimeString(),
            'location' => $obj->user['location'],
            'blog' => $obj->user['website'],
            'email' => $obj->email,
        ];
    }

    public function tplRepository($repo, $slug = false)
    {
        $organization = $this->organization($repo);

        if (!$organization) {
            return;
        }

        return (object)[
            'provider_id' => $repo->uuid,
            'organization_id' => $organization->id,
            'organization_title' => $organization->username,
            'slug' => $repo->slug,
            'title' => $repo->slug,
            'fullname' => $repo->name,
            'is_private' => $repo->is_private,
            'html_url' => $repo->links->html->href,
            'description' => null,
            'fork' => $repo->fork_policy == 'allow_forks' ? true : false,
            'url' => $repo->links->self->href,
            'since' => Carbon::parse($repo->created_on)->toDateTimeString(),
            'pushed_at' => Carbon::parse($repo->updated_on)->toDateTimeString(),
            'ssh_url' => $repo->links->clone[1]->href,
            'clone_url' => $repo->links->clone[0]->href,
            'homepage' => $repo->links->html->href,
            'default_branch' => isset($repo->mainbranch) ? (isset($repo->mainbranch->name) ? $repo->mainbranch->name : $repo->mainbranch) : null,
        ];
    }

    public function tplIssue($obj, $productBacklogId)
    {
        if (isset($obj->assignee->username)) {
            $user = User::where('username', $obj->assignee->username)
                ->where('provider', 'bitbucket')->first();
        }

        return [
            'provider_id' => $obj->repository->uuid,
            'user_id' => isset($user->id) ? $user->id : Auth::user()->id,
            'product_backlog_id' => $productBacklogId,
            'effort' => 0,
            'config_issue_effort_id' => 1,
            'issue_type_id' => 1,
            'number' => $obj->id,
            'title' => $obj->title,
            'description' => $obj->content->raw,
            'state' => $obj->state,
            'html_url' => $obj->content->html,
            'created_at' => Carbon::parse($obj->created_on)->toDateTimeString(),
            'updated_at' => Carbon::parse($obj->created_on)->toDateTimeString(),
        ];
    }

    public function tplOrganization($obj)
    {
        $propertyRepositoriesHref = property_exists($obj->links, "repositories") ? $obj->links->repositories->href : '';
        $propertyHooksHref = property_exists($obj->links, "hooks") ? $obj->links->hooks->href : '';
        $propertyWebsite = property_exists($obj, "website") ? $obj->website : '';
        $propertyLocation = property_exists($obj, "location") ? $obj->location : '';
        $propertyCreatedOn = property_exists($obj, "created_on") ? $obj->created_on : date('Y-m-d H:i:s');

        return [
            'provider_id' => $obj->uuid,
            'username' => $obj->username,
            'url' => $obj->links->self->href,
            'repos_url' => $propertyRepositoriesHref,
            'events_url' => null,
            'hooks_url' => $propertyHooksHref,
            'issues_url' => null,
            'members_url' => null,
            'public_members_url' => null,
            'avatar_url' => $obj->links->avatar->href,
            'description' => null,
            'title' => $obj->display_name,
            'blog' => $propertyWebsite,
            'location' => $propertyLocation,
            'email' => null,
            'public_repos' => null,
            'html_url' => $obj->links->html->href,
            'total_private_repos' => null,
            'since' => Carbon::parse($propertyCreatedOn)->toDateTimeString(),
            'disk_usage' => null,
            'provider' => 'bitbucket'
        ];
    }

    public function readRepositories($page = 1, &$repos = null)
    {
        $url = self::API_URL . self::API_VER . 'repositories?token=' . Auth::user()->token . '&role=member&page=' . $page . '&pagelen=100';

        $repos = $this->assertTokenNotExpired(Helper::request($url), $url);

        $response = collect($repos->values)->map(function ($repo) {
            return $this->tplRepository($repo);
        });

        return $response;
    }

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null)
    {
    }

    public function organization($obj)
    {
        if (!isset($obj->owner)) {
            return false;
        }

        $endPoint = strtolower($obj->owner->type) == 'user' ? 'users' : 'teams';

        $url = self::API_URL . self::API_VER . $endPoint . '/' . $obj->owner->username;

        $response = (object)$this->assertTokenNotExpired(Helper::request($url), $url);

        $data = $this->tplOrganization($response);

        $organization = Organization::updateOrCreate(['provider_id' => $data['provider_id']], $data);

        $organization->users()->sync([Auth::id()]);

        return $organization;
    }


    /**
     * Retrieves all repo collaborators in case the owner is logged in
     *
     * @param $owner
     * @param $repo
     * @param null $providerId
     */
    public function readCollaborators($owner, $repo, $providerId = null)
    {
        $url = self::API_URL . '/1.0/privileges/' . $owner . '/' . $repo;

        $collaborators = $this->assertTokenNotExpired(Helper::request($url), $url);

        $userId = null;

        if (is_null($collaborators)) {
            return;
        }

        foreach ($collaborators as $collaborator) {
            $user = User::where('provider', 'bitbucket')->where('username', $collaborator->user->username)->first();

            if (is_null($user)) {
                $url = self::API_URL . self::API_VER . 'users/' . $collaborator->user->username;

                $user = $this->assertTokenNotExpired(Helper::request($url), $url);

                $data = [
                    'provider_id' => $user->uuid,
                    'provider' => 'bitbucket',
                    'username' => $user->username,
                    'name' => $user->display_name,
                    'avatar' => $user->links->avatar->href,
                    'html_url' => $user->links->html->href,
                    'since' => Carbon::parse($user->created_on)->toDateTimeString(),
                    'location' => $user->location,
                    'blog' => $user->website,
                ];

                $user = User::create($data);
            }

            $userId[] = $user->id;
        }

        $organization = Organization::where('username', $owner)
            ->where('provider', 'bitbucket')->first()->users();

        $organization->syncWithoutDetaching($userId);
    }

    public function createBranches($owner, $product_backlog_id, $repo, $providerId = null)
    {
        $branches = collect(Helper::request(self::API_URL . '/1.0/repositories/' . $owner . '/' . $repo . '/branches'));

        $branchesData = [];
        foreach ($branches as $branchName => $branchData) {
            $branchesData[] = [
                'product_backlog_id' => $product_backlog_id,
                'title' => $branchName,
                'sha' => $branchData->raw_node,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        if ($branchesData) {
            Branch::insert($branchesData);
        }
    }

    public function readIssues()
    {
        $repos = ProductBacklog::with('organization')->get();

        foreach ($repos as $repo) {
            $url = self::API_URL . self::API_VER . 'repositories/' . $repo->organization->username . '/' . $repo->title . '/issues';

            $issues = $this->assertTokenNotExpired(Helper::request($url), $url);

            if (!empty($issues->values)) {
                foreach ($issues->values as $issue) {
                    $data = $this->tplIssue($issue, $repo->id);

                    if (!Issue::where('provider_id', $data['provider_id'])->where('number', $data['number'])->where('provider', 'bitbucket')->first()) {
                        Issue::create($data)->users()->sync([$data['user_id']]);
                    }
                }
            }

        }
    }


    public function createOrUpdateIssue($obj)
    {
    }

    public function createOrUpdateIssueComment($obj, $verb = 'POST')
    {
    }

    public function deleteIssueComment($obj)
    {
    }

    /**
     * will call the refresh token method in case the token expired
     * @param $obj
     * @param $url
     * @return mixed
     */
    private function assertTokenNotExpired($obj, $url)
    {
        if (isset($obj->type) && $obj->type == 'error') {
            return $this->refreshToken($url);
        }

        return $obj;
    }

    /**
     * it will refresh the user token and then retry the failed request
     * @param $failedUrlRequest
     * @return mixed
     */
    private function refreshToken($failedUrlRequest)
    {
        $options = [
            'auth' => [config('services.bitbucket.client_id'), config('services.bitbucket.client_secret')],
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => Auth::user()->refresh_token
            ]
        ];

        $response = (new GuzzleClient)
            ->post('https://bitbucket.org/site/oauth2/access_token', $options)
            ->getBody()->getContents();

        $response = json_decode($response, true);

        Auth::user()->update([
            'token' => $response['access_token'],
            'refresh_token' => $response['refresh_token']
        ]);

        return Helper::request($failedUrlRequest);
    }
}
