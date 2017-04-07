<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Classes;

use Auth;
use Carbon;
use GitScrum\Models\Branch;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use GitScrum\Contracts\ProviderInterface;

class Github implements ProviderInterface
{
    private $organization = [];

    public function tplUser($obj)
    {
        return [
            'provider_id' => $obj->id,
            'provider' => 'github',
            'username' => isset($obj->login) ? $obj->login : $obj->nickname,
            'name' => isset($obj->name) ? $obj->name : null,
            'token' => isset($obj->token) ? $obj->token : null,
            'avatar' => isset($obj->user['avatar_url']) ? $obj->user['avatar_url'] : $obj->avatar_url,
            'html_url' => isset($obj->user['html_url']) ? $obj->user['html_url'] : $obj->html_url,
            'bio' => isset($obj->user['bio']) ? $obj->user['bio'] : null,
            'since' => isset($obj->user['created_at']) ? Carbon::parse($obj->user['created_at'])->toDateTimeString() : Carbon::now(),
            'location' => isset($obj->user['location']) ? $obj->user['location'] : null,
            'blog' => isset($obj->user['blog']) ? $obj->user['blog'] : null,
            'email' => isset($obj->email) ? $obj->email : null,
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
        if (isset($obj->user->login)) {
            $user = User::where('username', $obj->user->login)
                ->where('provider', 'github')->first();
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
            'html_url' => $obj->html_url,
            'created_at' => $obj->created_at,
            'updated_at' => $obj->updated_at,
        ];
    }

    public function tplOrganization($obj)
    {
        return [
            'provider_id' => $obj->id,
            'username' => $obj->login,
            'url' => isset($obj->url) ? $obj->url : null,
            'repos_url' => isset($obj->repos_url) ? $obj->repos_url : null,
            'events_url' => isset($obj->events_url) ? $obj->events_url : null,
            'hooks_url' => isset($obj->hooks_url) ? $obj->hooks_url : null,
            'issues_url' => isset($obj->issues_url) ? $obj->issues_url : null,
            'members_url' => isset($obj->members_url) ? $obj->members_url : null,
            'public_members_url' => isset($obj->public_members_url) ? $obj->public_members_url : null,
            'avatar_url' => isset($obj->avatar_url) ? $obj->avatar_url : null,
            'description' => isset($obj->description) ? $obj->description : null,
            'title' => isset($obj->name) ? $obj->name : null,
            'blog' => isset($obj->blog) ? $obj->blog : null,
            'location' => isset($obj->location) ? $obj->location : null,
            'email' => isset($obj->email) ? $obj->email : null,
            'public_repos' => isset($obj->public_repos) ? $obj->public_repos : null,
            'html_url' => isset($obj->html_url) ? $obj->html_url : null,
            'total_private_repos' => isset($obj->total_private_repos) ? $obj->total_private_repos : null,
            'since' => Carbon::parse((isset($obj->created_at) ? $obj->created_at : Carbon::now()))->toDateTimeString(),
            'disk_usage' => isset($obj->disk_usage) ? $obj->disk_usage : null,
        ];
    }

    public function readRepositories($page = 1, &$repos = null)
    {
        $response = collect(Helper::request('https://api.github.com/user/repos?page='. $page))->map(function ($repo) {
            return $this->tplRepository($repo);
        });

        if (is_null($repos)) {
            $repos = collect();
        }

        $repos->push($response);

        if ($response->count() == 30) {
            $this->readRepositories(++$page, $repos);
        }

        return $repos->flatten(1)->sortBy('title');
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
        if (!array_key_exists($login, $this->organization)) {
            $organization = Organization::where('username', $login)
                ->where('provider', 'github')->first();

            if (!isset($organization)) {
                $response = Helper::request('https://api.github.com/orgs/'.$login);

                if (!isset($response->id)) {
                    $response = Helper::request('https://api.github.com/users/'.$login);
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

        collect(Helper::request('https://api.github.com/repos/'.$owner.'/'.$repo.'/collaborators'))
            ->map(function ($collaborator) use ($ids) {
                $user = User::where('username', $collaborator->login)
                ->where('provider', 'github')->first();

                if (!isset($user)) {
                    $user = User::create($this->tplUser($collaborator));
                }

                $ids->push($user->id);
            });

        $organization = Organization::where('username', $owner)
            ->where('provider', 'github')->first()->users();

        $organization->syncWithoutDetaching($ids->diff($organization->pluck('user_id')->toArray()));
    }

    public function createBranches($owner, $productBacklogId, $repo, $providerId = null, $page = 1)
    {
        $branches = collect(Helper::request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/branches?page='.$page));

        $branches->map(function ($branch) use ($productBacklogId) {
            $data = [
                'product_backlog_id' => $productBacklogId,
                'title' => $branch->name,
                'sha' => $branch->commit->sha,
            ];
            Branch::create($data);
        });

        if ($branches->count()==30) {
            $this->createBranches($owner, $productBacklogId, $repo, $providerId, ++$page);
        }
    }

    public function readIssues($productBacklogId = null)
    {
        if (is_null($productBacklogId)) {
            $productBacklog = ProductBacklog::all();
        } else {
            $productBacklog = ProductBacklog::find($productBacklogId);
        }

        $repos = $productBacklog->map(function ($repo) {
            $issues = collect(Helper::request('https://api.github.com/repos/'.$repo->organization->username.
                DIRECTORY_SEPARATOR.$repo->title.'/issues?state=all'))->map(function ($issue) use ($repo) {
                    if (isset($issue->id)) {
                        $data = $this->tplIssue($issue, $repo->id);

                        if (!Issue::where('provider_id', $issue->id)->where('provider', 'github')->first()) {
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
