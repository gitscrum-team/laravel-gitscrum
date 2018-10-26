<?php

namespace GitScrum\Classes;

use Auth;
use Carbon;
use GitScrum\Models\Branch;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use GitScrum\Contracts\ProviderInterface;

class Gitea implements ProviderInterface
{
    private $organization = [];

    public static function login($username, $passwd)
    {
        $response = collect(self::request(env('GITEA_INSTANCE_URI').'api/v1/users/'.$username.'/tokens', array('username' => $username, 'passwd' => $passwd)));

        if (!$response || !$response[0]->sha1) {
            return null;
        }

        $user = collect(self::request(env('GITEA_INSTANCE_URI').'api/v1/users/'.$username, array('username' => $username, 'passwd' => $passwd)));
        $user= $user->all();
        $user['token'] = $response[0]->sha1;
        $user = json_decode(json_encode($user));
        return $user;
    }

    public static function request($url, $auth = null, $customRequest = null, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if (env('PROXY_PORT')) {
            curl_setopt($ch, CURLOPT_PROXYPORT, env('PROXY_PORT'));
            curl_setopt($ch, CURLOPT_PROXYTYPE, env('PROXY_METHOD'));
            curl_setopt($ch, CURLOPT_PROXY, env('PROXY_SERVER'));
        }

        if (env('PROXY_USER')) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, env('PROXY_USER').':'.env('PROXY_USER'));
        }

        if (!is_null($postFields)) {
            $postFields = json_encode($postFields);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json',
                'Content-Length: '.strlen($postFields), ]);
        }

        if (!is_null($customRequest)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $customRequest); //'PATCH'
        }

        if ($auth && isset($auth['username'])) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $auth['username'].':'.$auth['passwd']);
        }

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }
    
    public function tplUser($obj)
    {
        return [
            'provider_id' => $obj->id,
            'provider' => 'gitea',
            'username' => $obj->username,
            'name' => isset($obj->full_name) ? $obj->full_name : $obj->username,
            'token' => isset($obj->token) ? $obj->token : null,
            'avatar' => $obj->avatar_url,
            'email' => $obj->email,
        ];
    }

    public function tplRepository($repo, $slug = false)
    {
        return (object) [
            'provider_id' => $repo->id,
            'organization_id' => $this->organization($repo->owner->username),
            'organization_title' => $repo->owner->username,
            'slug' => $slug ? $slug : Helper::slug($repo->full_name),
            'title' => $repo->name,
            'fullname' => $repo->full_name,
            'is_private' => $repo->private,
            'html_url' => $repo->html_url,
            'description' => $repo->description,
            'fork' => $repo->fork,
            'url' => $repo->html_url,
            'since' => Carbon::parse($repo->created_at)->toDateTimeString(),
            'pushed_at' => Carbon::parse($repo->updated_at)->toDateTimeString(),
            'ssh_url' => $repo->ssh_url,
            'clone_url' => $repo->clone_url,
            'homepage' => $repo->html_url,
            'default_branch' => isset($repo->default_branch) ? $repo->default_branch : null,
        ];
    }

    public function tplIssue($obj, $productBracklogId)
    {
        if (isset($obj->user->login)) {
            $user = User::where('username', $obj->user->login)
                ->where('provider', 'gitea')->first();
        }

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
            'html_url' => $obj->url,
            'created_at' => $obj->created_at,
            'updated_at' => $obj->updated_at,
        ];
    }

    public function tplOrganization($obj)
    {
        return [
            'provider_id' => $obj->id,
            'username' => $obj->username,
            'url' => isset($obj->website) ? $obj->website : env('GITEA_INSTANCE_URI').$obj->username,
            'repos_url' => env('GITEA_INSTANCE_URI').$obj->username,
            'events_url' => null,
            'hooks_url' => null,
            'issues_url' => null,
            'members_url' => env('GITEA_INSTANCE_URI').$obj->username.'/members',
            'public_members_url' => env('GITEA_INSTANCE_URI').$obj->username.'/members',
            'avatar_url' => $obj->avatar_url,
            'description' => isset($obj->description) ? $obj->description : null,
            'title' => !empty($obj->full_name) ? $obj->full_name : $obj->username,
            'blog' => null,
            'location' => isset($obj->location) ? $obj->location : null,
            'email' => null,
            'public_repos' => env('GITEA_INSTANCE_URI').$obj->username,
            'html_url' => isset($obj->website) ? $obj->website : env('GITEA_INSTANCE_URI').$obj->username,
            'total_private_repos' => null,
            'since' => Carbon::parse((isset($obj->created_at) ? $obj->created_at : Carbon::now()))->toDateTimeString(),
            'disk_usage' => null,
        ];
    }

    public function readRepositories($page = 1, &$repos = null)
    {
        $response = collect(self::request(env('GITEA_INSTANCE_URI').'api/v1/user/repos?token='.Auth::user()->token))->map(function ($repo) {
            return $this->tplRepository($repo);
        });

        if (is_null($repos)) {
            $repos = collect();
        }

        $repos->push($response);

        /*
        // not seeing gogs/gitea repos paging
        if ($response->count() == 30) {
            $this->readRepositories(++$page, $repos);
        }
        */

        return $repos->flatten(1)->sortBy('title');
    }

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null)
    {
        $params = [
            'name' => str_slug($obj->title, '-'),
            'description' => $obj->description,
        ];

        if (is_null($oldTitle)) {
            $endpoint = env('GITEA_INSTANCE_URI').'api/v1/org/'.$owner.'/repos?token='.Auth::user()->token;

            if (Auth::user()->username == $owner) {
                $endpoint = env('GITEA_INSTANCE_URI').'api/v1/user/repos?token='.Auth::user()->token;
            }

            $response = self::request($endpoint, true, 'POST', $params);
            return (object) $response;
        } else {
            // gitea has no update repo api
            return null;
        }

        return null;
    }

    public function organization($login)
    {
        if (!array_key_exists($login, $this->organization)) {
            $organization = Organization::where('username', $login)
                ->where('provider', 'gitea')->first();

            if (!isset($organization)) {
                $response = self::request(env('GITEA_INSTANCE_URI').'api/v1/orgs/'.$login.'?token='.Auth::user()->token);

                if (!isset($response->id)) {
                    $response = self::request(env('GITEA_INSTANCE_URI').'api/v1/users/'.$login.'?token='.Auth::user()->token);
                }

                if (isset($response->id)) {
                    $organization = Organization::create($this->tplOrganization($response));
                }
            }

            if (is_null($organization->users()->where('users_has_organizations.user_id', Auth::id())
                ->where('users_has_organizations.organization_id', $organization->id)->first())) {
                $organization->users()->attach(Auth::id());
            }
            $this->organization[$login] = $organization;

            return $organization->id;
        }

        return $this->organization[$login]->id;
    }

    public function readCollaborators($owner, $repo, $providerId = null)
    {
        $ids = collect();

        collect(self::request(env('GITEA_INSTANCE_URI').'api/v1/repos/'.$owner.'/'.$repo.'/collaborators?token='.Auth::user()->token))
            ->map(function ($collaborator) use ($ids) {
                $user = User::where('username', $collaborator->login)
                ->where('provider', 'gitea')->first();

                if (!isset($user)) {
                    $user = User::create($this->tplUser($collaborator));
                }

                $ids->push($user->id);
            });

        $organization = Organization::where('username', $owner)
            ->where('provider', 'gitea')->first()->users();

        $organization->syncWithoutDetaching($ids->diff($organization->pluck('user_id')->toArray()));
    }

    public function createBranches($owner, $productBacklogId, $repo, $providerId = null, $page = 1)
    {
        // gitea has no create branch api
        return collect();
    }

    public function readIssues($productBacklogId = null)
    {
        if (is_null($productBacklogId)) {
            $productBacklog = ProductBacklog::all();
        } else {
            $productBacklog = ProductBacklog::find($productBacklogId);
        }

        $repos = $productBacklog->map(function ($repo) {
            $issues = collect(self::request(env('GITEA_INSTANCE_URI').'api/v1/repos/'.
                $repo->organization->username.
                DIRECTORY_SEPARATOR.$repo->title.'/issues?token='.Auth::user()->token))->map(function ($issue) use ($repo) {
                    if (isset($issue->id)) {
                        $data = $this->tplIssue($issue, $repo->id);

                        if (!Issue::where('provider_id', $issue->id)->where('provider', 'gitea')->first()) {
                            Issue::create($data)->users()->attach($data['user_id']);
                        }
                    }
                });
        });
    }

    public function createOrUpdateIssue($obj)
    {
        $params = [
            'title' => $obj->title,
            'body' => $obj->description,
        ];

        $response = self::request(
            env('GITEA_INSTANCE_URI').'api/v1/repos/'.
            $obj->productBacklog->organization->username.DIRECTORY_SEPARATOR.
            $obj->productBacklog->title.'/issues'.(isset($obj->number) ? DIRECTORY_SEPARATOR.$obj->number : '').'?token='.Auth::user()->token,
            true,
            isset($obj->number) ? 'PATCH' : 'POST',
            $params
        );


        return (object) $response;
    }

    public function createOrUpdateIssueComment($obj, $verb = 'POST')
    {
        $params = [
            'body' => $obj->comment,
        ];

        if($verb == 'POST' && $obj->provider_id) {
            $verb = 'PATCH';
        }

        $response = self::request(
            env('GITEA_INSTANCE_URI').'api/v1/repos/'.
            $obj->issue->productBacklog->organization->username.DIRECTORY_SEPARATOR.(
                $verb == 'POST' 
                ?
                $obj->issue->productBacklog->title.'/issues/'.($obj->issue->number).'/comments?token='.Auth::user()->token
                :
                $obj->issue->productBacklog->title.'/issues/comments/'.($obj->provider_id).'?token='.Auth::user()->token
            ),
            true,
            $verb,
            $params
        );

        return (object) $response;
    }

    public function deleteIssueComment($obj)
    {
        return $this->createOrUpdateIssueComment($obj, 'DELETE');
    }
}
