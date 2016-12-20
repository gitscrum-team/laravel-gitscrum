<?php

namespace GitScrum\Classes;

use Auth;
use GitScrum\Models\Branch;
use GitScrum\Models\Commit;
use GitScrum\Models\ConfigStatus;
use GitScrum\Models\User;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ProductBacklog;
use Carbon\Carbon;
use GitScrum\Libraries\Phpcs;

class Github
{
    public function templateRepository($repo, $slug = false)
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

    public function readRepositories()
    {
        $repos = collect($this->request('https://api.github.com/user/repos'));

        $response = $repos->map(function ($repo) {
            return $this->templateRepository($repo);
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

            $response = $this->request($endpoint, true, 'POST', $params);
        } else {
            $oldTitle = str_slug($oldTitle, '-');
            $response = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$oldTitle, true, 'POST', $params);
        }

        return (object) $response;
    }

    public function organization($login)
    {
        $orgData = $this->request('https://api.github.com/orgs/'.$login);

        if (!isset($orgData->id)) {
            $orgData = $this->request('https://api.github.com/users/'.$login);
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
            $organization = Organization::where('username', $orgData->login)->first();
        }

        $organization->users()->sync([Auth::id()]);

        return $organization->id;
    }

    public function readCollaborators($owner, $repo)
    {
        $collaborators = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/collaborators');
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
                    $user = User::where('username', $collaborator->login)->first();
                }

                $userId[] = $user->id;
            }
        }

        $organization = Organization::where('username', $owner)->first()->users();
        $organization->sync($userId);
    }

    public function createBranches($owner, $product_backlog_id, $repo)
    {
        $y = 0;
        for ($i = 1; $i > $y; ++$i) {
            $branches = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/branches?page='.$i);
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
            $issues = $this->request('https://api.github.com/repos/'.$repo->organization->username.DIRECTORY_SEPARATOR.$repo->title.'/issues?state=all');

            foreach ($issues as $issue) {
                $user = User::where('username', $issue->user->login)->first();

                $data = [
                    'provider_id' => $issue->id,
                    'user_id' => isset($user_id) ? $user->id : Auth::user()->id,
                    'product_backlog_id' => $repo->id,
                    'effort' => 0,
                    'config_issue_effort_id' => 1,
                    'issue_type_id' => 1,
                    'number' => $issue->number,
                    'title' => $issue->title,
                    'description' => $issue->body,
                    'state' => $issue->state,
                    'html_url' => $issue->html_url,
                    'created_at' => $issue->created_at,
                    'updated_at' => $issue->updated_at,
                ];

                if (!is_null($issue->closed_at)) {
                    $data['closed_at'] = Carbon::parse($issue->closed_at)->format('Y-m-d h:m:s');
                    $data['closed_user_id'] = $data['user_id'];
                    $data['config_status_id'] = ConfigStatus::where('type', 'issue')
                        ->where('is_closed', 1)->first()->id;
                }

                if (!Issue::where('provider_id', $issue->id)->first()) {
                    Issue::create($data)->users()->sync([$data['user_id']]);
                }
                //foreach ($issue->assignees as $assign) {
                //    User::where('provider_id', $assign->id)->first()->issues()->sync([$issueId], false);
                //}
            }
        }
    }

    public function createOrUpdateIssue($obj)
    {
        $params = [
            'title' => $obj->title,
            'body' => $obj->description,
        ];

        $response = $this->request('https://api.github.com/repos/'.
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

        $response = $this->request('https://api.github.com/repos/'.
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

    private function request($url, $auth = true, $customRequest = null, $postFields = null)
    {
        $user = Auth::user();
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
            curl_setopt($ch, CURLOPT_HTTPHEADER,  ['Content-Type: application/json',
                'Content-Length: '.strlen($postFields), ]);
        }

        if (!is_null($customRequest)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $customRequest); //'PATCH'
        }

        if ($auth && isset($user->username)) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $user->username.':'.$user->token);
        }

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    /*
    public function organizations(){
        $this->request('https://api.github.com/user/orgs');
    }

    public function repositories($org){
        ///orgs/:org/repos
        return $this->request('https://api.github.com/orgs/'.$org.'/repos');
    }
    */

    public function setCommits($owner, $repo, $branch, $since = null)
    {
        ////repos/:owner/:repo/commits?sha=branchname
        $y = 0;
        for ($i = 1; $i > $y; ++$i) {
            $commits = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/commits?page='.$i.
            '&sha='.$branch.(is_null($since) ? '' : '&since='.$since));
            $branch = Branch::join('product_backlogs', 'branches.product_backlog_id', '=', 'repositories.id')
                            ->where('branches.name', $branch)
                            ->where('product_backlogs.name', $repo)
                            ->select('branches.id AS branch_id', 'repositories.id AS product_backlog_id')->first();
            $CommitRepository = new CommitRepository();
            foreach ($commits as $commit) {
                try {
                    $user = User::where('provider_id', $commit->author->id)->first();
                    $userId = $user->id;
                } catch (\Exception $e) {
                    $userId = 0;
                }
                try {
                    if (isset($commit->sha)) {
                        $data = [
                            'product_backlog_id' => $branch->product_backlog_id,
                            'branch_id' => $branch->branch_id,
                            'user_id' => $userId,
                            'sha' => $commit->sha,
                            'url' => $commit->url,
                            'message' => $commit->commit->message,
                            'html_url' => $commit->html_url,
                            'date' => $commit->commit->author->date,
                            'tree_sha' => $commit->commit->tree->sha,
                            'tree_url' => $commit->commit->tree->url,
                        ];
                        $commitData = $CommitRepository->add($data);
                        $this->setCommitFiles($owner, $repo, $commitData->sha, $commitData);
                    }
                } catch (\Exception $e) {
                    dd($data, $commit);
                }
            }
            if (count($commits) < 30) {
                $y = $i + 2;
            }
        }
    }

    public function setCommitFiles($owner, $repo, $sha, $objCommit)
    {
        // /repos/:owner/:repo/commits/:sha
        $commits = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/commits/'.$sha);
        $Phpcs = new Phpcs();
        $CommitRepository = new CommitRepository();
        foreach ($commits->files as $commit) {
            try {
                $contents = $this->request($commit->contents_url);
                $fileRaw = file_get_contents($contents->download_url);
                $data = [
                    'commit_id' => $objCommit->id,
                    'sha' => $commit->sha,
                    'filename' => $commit->filename,
                    'status' => $commit->status,
                    'additions' => $commit->additions,
                    'deletions' => $commit->deletions,
                    'changes' => $commit->changes,
                    'raw_url' => $commit->raw_url,
                    'raw' => $fileRaw,
                    'patch' => (isset($commit->patch) ? $commit->patch : ''),
                ];
                $commitData = $CommitRepository->addFile($data);
                //$Phpcs->init($fileRaw, $commitData->id);
            } catch (\Exception $e) {
                echo 'erro files ... ';
            }
        }
    }

    public function getCommit($owner, $repo, $sha)
    {
        // /repos/:owner/:repo/commits/:sha
        $commits = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/commits/'.$sha);
        dd($commits);
        /*
        foreach ($commits as $commit) {
            $data = [
                'commit_id'=>$objCommit->id,
                'sha'=>,
                'filename'=>,
                'status'=>,
                'additions'=>,
                'deletetions'=>,
                'changes'=>,
                'raw_url'=>,
                'patch'=>
            ];
        }*/
    }

    public function setPullRequest($owner, $repo)
    {
        ///repos/:owner/:repo/pulls
        $pulls = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.$repo.'/pulls');
        $repository = Repository::where('name', $repo)->first();
        $PullRequestRepository = new PullRequestRepository();
        foreach ($pulls as $pull) {
            $branch = Branch::where('name', $pull->head->ref)->first();
            try {
                $user = User::where('provider_id', $pull->user->id)->first();
                $userId = $user->id;
            } catch (\Exception $e) {
                $userId = 0;
            }

            try {
                $headBranchId = $branch->id;
            } catch (\Exception $e) {
                $headBranchId = 0;
            }

            try {
                $branch = Branch::where('name', $pull->base->ref)->first();
                $baseBranchId = $branch->id;
            } catch (\Exception $e) {
                $baseBranchId = 0;
            }

            $data = [
                'provider_id' => $pull->id,
                'number' => $pull->number,
                'user_id' => $userId,
                'product_backlog_id' => $repository->id,
                'url' => $pull->url,
                'html_url' => $pull->html_url,
                'issue_url' => $pull->issue_url,
                'commits_url' => $pull->commits_url,
                'state' => $pull->state,
                'title' => $pull->title,
                'body' => $pull->body,
                'github_created_at' => $pull->created_at,
                'github_updated_at' => $pull->updated_at,
                'head_branch_id' => $headBranchId,
                'base_branch_id' => $baseBranchId,
            ];

            $pull = $PullRequestRepository->add($data);

            $commits = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.
                $repo.'/pulls/'.$pull->number.'/commits');
            foreach ($commits as $commit) {
                $c = Commit::where('sha', '=', $commit->sha)->first();
                $pull->commit()->sync([$c->id], false);
            }
        }
    }

    public function getStatsCommitActivity($owner, $repo)
    {
        ///repos/:owner/:repo/stats/contributors
        $stats = $this->request('https://api.github.com/repos/'.$owner.DIRECTORY_SEPARATOR.
            $repo.'/stats/commit_activity');
        $arr = [];
        foreach ($stats as $stat) {
            $arr[] = $stat->total;
        }

        return $arr;
    }
}
