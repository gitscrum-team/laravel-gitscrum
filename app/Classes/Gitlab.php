<?php

namespace GitScrum\Classes;

use Auth;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use Carbon\Carbon;
use GitScrum\Contracts\ProviderInterface;

class Gitlab implements ProviderInterface
{
    public function templateUser($obj)
    {
        return [
            'provider_id' => $obj->id,
            'provider' => 'gitlab',
            'username' => $obj->nickname,
            'name' => $obj->name,
            'token' => $obj->token,
            'avatar' => @$obj->user['avatar_url'],
            'html_url' => @$obj->user['web_url'],
            'bio' => @$obj->user['bio'],
            'since' => Carbon::parse($obj->user['created_at'])->toDateTimeString(),
            'location' => @$obj->user['location'],
            'blog' => @$obj->user['blog'],
            'email' => $obj->email,
        ];
    }

    public function templateRepository($repo, $slug = false)
    {
        return (object) [
            'provider_id' => $repo->id,
            'organization_id' => $this->organization($repo),
            'organization_title' => $repo->owner->username,
            'slug' => $slug ? $slug : Helper::slug($repo->path),
            'title' => $repo->path,
            'fullname' => $repo->name,
            'is_private' => $repo->public == true,
            'html_url' => $repo->http_url_to_repo,
            'description' => $repo->description,
            'fork' => null,
            'url' => $repo->web_url,
            'since' => Carbon::parse($repo->created_at)->toDateTimeString(),
            'pushed_at' => Carbon::parse($repo->last_activity_at)->toDateTimeString(),
            'ssh_url' => $repo->ssh_url_to_repo,
            'clone_url' => $repo->ssh_url_to_repo,
            'homepage' => $repo->web_url,
            'default_branch' => $repo->default_branch,
        ];
    }

    public function templateIssue($obj, $productBacklogId)
    {
        $user = User::where('username', @$obj->assignee->username)
            ->where('provider', 'gitlab')->first();

        return [
            'provider_id' => $obj->id,
            'user_id' => isset($user->id) ? $user->id : Auth::user()->id,
            'product_backlog_id' => $productBacklogId,
            'effort' => 0,
            'config_issue_effort_id' => 1,
            'issue_type_id' => 1,
            'number' => $obj->iid,
            'title' => $obj->title,
            'description' => $obj->description,
            'state' => $obj->state,
            'html_url' => $obj->web_url,
            'created_at' => Carbon::parse($obj->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($obj->updated_at)->toDateTimeString(),
        ];
    }

    public function readRepositories()
    {
        $repos = collect(Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects?access_token='.Auth::user()->token));

        $response = $repos->map(function ($repo) {
            return $this->templateRepository($repo);
        });

        return $response;
    }

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null)
    {
    }

    public function organization($obj)
    {
        $data = [
            'provider_id' => $obj->owner->id,
            'username' => $obj->owner->username,
            'url' => $obj->owner->web_url,
            'repos_url' => null,
            'events_url' => null,
            'hooks_url' => null,
            'issues_url' => null,
            'members_url' => null,
            'public_members_url' => null,
            'avatar_url' => $obj->owner->avatar_url,
            'description' => null,
            'title' => $obj->owner->username,
            'blog' => null,
            'location' => null,
            'email' => null,
            'public_repos' => null,
            'html_url' => null,
            'total_private_repos' => null,
            'since' => @Carbon::parse($obj->namespace->created_at)->toDateTimeString(),
            'disk_usage' => null,
        ];

        try {
            $organization = Organization::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            $organization = Organization::where('username', $data['username'])
                ->where('provider', 'gitlab')->first();
        }

        $organization->users()->sync([Auth::id()]);

        return $organization->id;
    }

    public function readCollaborators($owner, $repo)
    {
    }

    public function createBranches($owner, $product_backlog_id, $repo)
    {
    }

    public function readIssues()
    {
        $repos = ProductBacklog::all();

        foreach ($repos as $repo) {
            $issues = Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects/'.$repo->provider_id.
                '/issues?access_token='.Auth::user()->token);

            $issues = is_array($issues) ? $issues : [$issues];

            foreach ($issues as $issue) {
                try{
                    $data = $this->templateIssue($issue, $repo->id);
                    if (!Issue::where('provider_id', $data['provider_id'])->where('provider', 'gitlab')->first()) {
                        Issue::create($data)->users()->sync([$data['user_id']]);
                    }
                } catch( \Exception $e){

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
}
