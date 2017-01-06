<?php

namespace GitScrum\Classes;

use Auth;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use GitScrum\Models\Branch;
use Carbon\Carbon;
use GitScrum\Contracts\ProviderInterface;

class Gitlab implements ProviderInterface
{
    private $gitlabGroups;

    public function tplUser($obj)
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

    public function tplRepository($repo, $slug = false)
    {
        $organization = $this->organization($repo);

        if (!$organization) {
            return;
        }

        return (object) [
            'provider_id' => $repo->id,
            'organization_id' => $organization->id,
            'organization_title' => $organization->username,
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

    public function tplIssue($obj, $productBacklogId)
    {
        if (isset($obj->assignee->username)) {
            $user = User::where('username', @$obj->assignee->username)
                ->where('provider', 'gitlab')->first();
        }

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
            'html_url' => isset($obj->web_url) ? $obj->web_url : '',
            'created_at' => Carbon::parse($obj->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($obj->updated_at)->toDateTimeString(),
        ];
    }

    public function tplOrganization($obj)
    {
        return [
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
    }

    public function readRepositories($page = 1, &$repos = null)
    {
        $repos = collect(Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects?access_token='.Auth::user()->token));

        $response = $repos->map(function ($repo) {
            return $this->tplRepository($repo);
        });

        return $response;
    }

    public function createOrUpdateRepository($owner, $obj, $oldTitle = null)
    {
    }

    public function organization($obj)
    {
        if (!isset($obj->owner) && !isset($obj->namespace)) {
            return false;
        }

        if (!isset($obj->owner) && isset($obj->namespace)) {
            // To avoid to make unnecessary calls to the api to get the groups info saving the fetched groups into a private variable
            if (!isset($this->gitlabGroups[$obj->namespace->id])) {
                $group = current(collect(Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/groups/'.$obj->namespace->id.'?access_token='.Auth::user()->token)));

                $this->gitlabGroups[$obj->namespace->id] = $group;
            }

            $group = $this->gitlabGroups[$obj->namespace->id];

            $obj->owner = new \stdClass();
            $obj->owner->id = $group['id'];
            $obj->owner->username = $group['path'];
            $obj->owner->web_url = $group['web_url'];
            $obj->owner->avatar_url = $group['avatar_url'];
        }

        $data = $this->tplOrganization($obj);

        try {
            $organization = Organization::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            $organization = Organization::where('username', $data['username'])
                ->where('provider', 'gitlab')->first();
        }

        $organization->users()->sync([Auth::id()]);

        return $organization;
    }

    /**
     * Get all members from a specific group in gitlab.
     *
     * @param $group
     *
     * @return \Illuminate\Support\Collection
     */
    private function getGroupsMembers($group)
    {
        $members = collect(Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/groups/'.$group.'/members?access_token='.Auth::user()->token));

        return $members;
    }

    /**
     * Get all members from the project in gitlab.
     *
     * @param $projectId
     *
     * @return \Illuminate\Support\Collection
     */
    private function getProjectMembers($projectId)
    {
        $members = collect(Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects/'.$projectId.'/members?access_token='.Auth::user()->token));

        return $members;
    }

    /**
     * A project can be shared with many groups and each group has its members
     * This method retrieves all members from the groups that the project is shared with.
     *
     * @param $projectId
     *
     * @return \Illuminate\Support\Collection|static
     */
    private function getProjectSharedGroupsMembers($projectId)
    {
        $project = Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects/'.$projectId.'?access_token='.Auth::user()->token);

        $members = new \Illuminate\Support\Collection();

        if (!empty($project->shared_with_groups)) {
            foreach ($project->shared_with_groups as $group) {
                $groupsMembers = $this->getGroupsMembers($group->group_id);

                $members = $members->merge($groupsMembers);
            }
        }

        return $members;
    }

    /**
     * Retrives all project members from three pespectives
     *  Members from the project itself
     *  Members of the groups that the project is owned by
     *  Members by the groups that the project is shared with.
     *
     * @param $owner
     * @param $repo
     * @param null $providerId
     */
    public function readCollaborators($owner, $repo, $providerId = null)
    {
        $collaborators = $this->getGroupsMembers($owner);

        if ($providerId) {
            $projectMembers = $this->getProjectMembers($providerId);
            $collaborators = $collaborators->merge($projectMembers);

            $projectSharedGroupsMembers = $this->getProjectSharedGroupsMembers($providerId);
            $collaborators = $collaborators->merge($projectSharedGroupsMembers);
        }

        foreach ($collaborators as $collaborator) {
            if (isset($collaborator->id)) {
                $data = [
                    'provider_id' => $collaborator->id,
                    'provider' => 'gitlab',
                    'username' => $collaborator->username,
                    'name' => $collaborator->name,
                    'avatar' => $collaborator->avatar_url,
                    'html_url' => $collaborator->web_url,
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
                    $user = User::firstOrCreate($data);
                } catch (\Exception $e) {
                    $user = User::where('username', $collaborator->username)
                        ->where('provider', 'gitlab')->first();
                }

                $userId[] = $user->id;
            }
        }

        $organization = Organization::where('username', $owner)
            ->where('provider', 'gitlab')->first()->users();

        if (!$organization->userActive()->count()) {
            $organization->attach($userId);
        }
    }

    public function createBranches($owner, $product_backlog_id, $repo, $providerId = null)
    {
        $branches = collect(Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects/'.$providerId.'/repository/branches?access_token='.Auth::user()->token));

        $branchesData = [];
        foreach ($branches as $branch) {
            $branchesData[] = [
                'product_backlog_id' => $product_backlog_id,
                'title' => $branch->name,
                'sha' => $branch->commit->id,
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
        $repos = ProductBacklog::all();

        foreach ($repos as $repo) {
            $issues = Helper::request(env('GITLAB_INSTANCE_URI').'api/v3/projects/'.$repo->provider_id.
                '/issues?access_token='.Auth::user()->token);

            $issues = is_array($issues) ? $issues : [$issues];

            foreach ($issues as $issue) {
                try {
                    $data = $this->tplIssue($issue, $repo->id);
                    if (!Issue::where('provider_id', $data['provider_id'])->where('provider', 'gitlab')->first()) {
                        Issue::create($data)->users()->sync([$data['user_id']]);
                    }
                } catch (\Exception $e) {
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
