<?php

namespace GitScrum\Classes;

use Auth;
use GitScrum\Models\Branch;
use GitScrum\Models\Commit;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use Carbon\Carbon;
use GitScrum\Contracts\ProviderInterface;

class Github implements ProviderInterface
{
    public function tplUser($obj)
    {
        return [
            'provider_id' => $obj->id,
            'provider' => 'github',
            'username' => $obj->nickname,
            'name' => $obj->name,
            'token' => $obj->token,
            'avatar' => @$obj->user['avatar_url'],
            'html_url' => @$obj->user['html_url'],
            'bio' => @$obj->user['bio'],
            'since' => Carbon::parse($obj->user['created_at'])->toDateTimeString(),
            'location' => @$obj->user['location'],
            'blog' => @$obj->user['blog'],
            'email' => $obj->email,
        ];
    }

    public function tplRepository($repo, $slug = false)
    {

        return (object) [
            'provider_id' => $repo->id,
            'organization_id' => $this->organization($repo->owner->login),
            'organization_title' => $repo->owner->login,
            'slug' => $slug ? $slug : Helper::slug($repo->name),
            'title' => $repo->name,
            'fullname' => $repo->full_name,
            'is_private' => $repo->private,
            'html_url' => $repo->html_url,
            'description' => $repo->description,
            'fork' => $repo->fork,
            'url' => $repo->url,
            'since' => Carbon::parse($repo->created_at)->toDateTimeString(),
            'pushed_at' => Carbon::parse($repo->pushed_at)->toDateTimeString(),
            'ssh_url' => $repo->ssh_url,
            'clone_url' => $repo->clone_url,
            'homepage' => $repo->homepage,
            'default_branch' => $repo->default_branch,
        ];

    }

    public function tplIssue($obj, $productBracklogId)
    {
        $user = User::where('username', @$obj->user->login)
            ->where('provider', 'github')->first();

        return [
            'provider_id' => $obj->id,
            'user_id' => isset($user->id) ? $user->id : Auth::user()->id,
            'product_backlog_id' => $productBracklogId,
            'effort' => 0,
            'config_issue_effort_id' => 1,
            'issue_type_id' => 1,
            'number' => $obj->number,
            'title' => $obj->title,
            'description' => $obj->body,
            'state' => $obj->state,
            'html_url' => $obj->html_url,
            'created_at' => $obj->created_at,
            'updated_at' => $obj->updated_at,
        ];
    }

    public function readRepositories()
    {
        $repos = collect(Helper::request('https://api.github.com/user/repos'));

        $response = $repos->map(function ($repo) {
            return $this->tplRepository($repo);
        });

        return $response;
    }

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null)
    {
        $params = [
            'name' => str_slug($obj->title, '-'),
            'description' => $obj->description,
        ];

        if (is_null($oldTitle)) {
            $endpoint = 'https://api.github.com/orgs/'.$owner.'/repos';

            if (Auth::user()->username == $owner) {
                $endpoint = 'https://api.github.com/user/repos';
            }

            $response = Helper::request($endpoint, true, 'POST', $params);
        } else {
            $oldTitle = str_slug($oldTitle, '-');
            $response = Helper::request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$oldTitle, true, 'POST', $params);
        }

        return (object) $response;
    }

    public function organization($login)
    {

        $organization = Organization::where('username', $login)
            ->where('provider', 'github')->first();

        if( !isset($organization) )
        {

            $orgData = Helper::request('https://api.github.com/orgs/'.$login);

            if (!isset($orgData->id)) {
                $orgData = Helper::request('https://api.github.com/users/'.$login);
            }

            $data = [
                'provider_id' => @$orgData->id,
                'username' => @$orgData->login,
                'url' => @$orgData->url,
                'repos_url' => @$orgData->repos_url,
                'events_url' => @$orgData->events_url,
                'hooks_url' => @$orgData->hooks_url,
                'issues_url' => @$orgData->issues_url,
                'members_url' => @$orgData->members_url,
                'public_members_url' => @$orgData->public_members_url,
                'avatar_url' => @$orgData->avatar_url,
                'description' => @$orgData->description,
                'title' => @$orgData->name,
                'blog' => @$orgData->blog,
                'location' => @$orgData->location,
                'email' => @$orgData->email,
                'public_repos' => @$orgData->public_repos,
                'html_url' => @$orgData->html_url,
                'total_private_repos' => @$orgData->total_private_repos,
                'since' => @Carbon::parse($orgData->created_at)->toDateTimeString(),
                'disk_usage' => @$orgData->disk_usage,
            ];

            try {
                $organization = Organization::create($data);
            } catch (\Illuminate\Database\QueryException $e) {

            }

            $organization->users()->sync([Auth::id()]);

        }

        return $organization->id;
    }

    public function readCollaborators($owner, $repo, $providerId = null)
    {
        $collaborators = Helper::request('https://api.github.com/repos/'.$owner.'/'.$repo.'/collaborators');
        foreach ($collaborators as $collaborator) {
            if (isset($collaborator->id)) {
                $data = [
                    'provider_id' => $collaborator->id,
                    'username' => $collaborator->login,
                    'name' => $collaborator->login,
                    'avatar' => $collaborator->avatar_url,
                    'html_url' => $collaborator->html_url,
                    'email' => null,
                    'remember_token' => null,
                    'bio' => null,
                    'location' => null,
                    'blog' => null,
                    'since' => null,
                    'token' => null,
                    'position_held' => null,
                ];

                try {
                    $user = User::create($data);
                } catch (\Exception $e) {
                    $user = User::where('username', $collaborator->login)
                        ->where('provider', 'github')->first();
                }

                $userId[] = $user->id;
            }
        }

        $organization = Organization::where('username', $owner)
            ->where('provider', 'github')->first()->users();

        if(!$organization->where('user_id', Auth::user()->id)->count())
        {
            $organization->attach($userId);
        }
    }

    public function createBranches($owner, $product_backlog_id, $repo, $providerId = null)
    {
        $y = 0;
        for ($i = 1; $i > $y; ++$i) {
            $branches = Helper::request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/branches?page='.$i);
            foreach ($branches as $branch) {
                $data = [
                    'product_backlog_id' => $product_backlog_id,
                    'title' => $branch->name,
                    'sha' => $branch->commit->sha,
                ];
                Branch::create($data);
            }
            if (count($branches) < 30) {
                $y = $i + 2;
            }
        }
    }

    public function readIssues()
    {
        $repos = ProductBacklog::all();

        foreach ($repos as $repo) {
            $issues = Helper::request('https://api.github.com/repos/'.$repo->organization->username.
                DIRECTORY_SEPARATOR.$repo->title.'/issues?state=all');

            $issues = is_array($issues) ? $issues : [$issues];

            foreach ($issues as $issue) {
                try {
                    $data = $this->tplIssue($issue, $repo->id);
                } catch (\Exception $e) {
                }

                if (!Issue::where('provider_id', $issue->id)->where('provider', 'github')->first()) {
                    Issue::create($data)->users()->sync([$data['user_id']]);
                }
            }
        }
    }

    public function createOrUpdateIssue($obj)
    {
        $params = [
            'title' => $obj->title,
            'body' => $obj->description,
        ];

        $response = Helper::request('https://api.github.com/repos/'.
            $obj->productBacklog->organization->username.DIRECTORY_SEPARATOR.
            $obj->productBacklog->title.'/issues'.(isset($obj->number) ? DIRECTORY_SEPARATOR.$obj->number : ''),
            true, 'POST', $params);

        return (object) $response;
    }

    public function createOrUpdateIssueComment($obj, $verb = 'POST')
    {
        $params = [
            'body' => $obj->comment,
        ];

        $response = Helper::request('https://api.github.com/repos/'.
            $obj->issue->productBacklog->organization->username.DIRECTORY_SEPARATOR.
            $obj->issue->productBacklog->title.'/issues'.(isset($obj->provider_id) ? '' : DIRECTORY_SEPARATOR.$obj->issue->number).'/comments'.
            (isset($obj->provider_id) ? DIRECTORY_SEPARATOR.$obj->provider_id : ''),
            true, $verb, $params);

        return (object) $response;
    }

    public function deleteIssueComment($obj)
    {
        return $this->createOrUpdateIssueComment($obj, 'DELETE');
    }
}
