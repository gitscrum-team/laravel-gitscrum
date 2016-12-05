<?php

namespace GitScrum\Classes;

use Auth;
use GitScrum\Models\Branch;
use GitScrum\Models\Commit;
use GitScrum\Models\User;
use GitScrum\Models\Organization;
use Carbon\Carbon;
use GitScrum\Libraries\Phpcs;

class Github
{
    public function getRepositoryTemplate($repo, $slug = false)
    {
        return (object) [
            'github_id' => $repo->id,
            'organization_id' => $this->organization($repo->owner->login),
            'organization_title' => $repo->owner->login,
            'slug' => !$slug?Helper::slug($repo->name):$slug,
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

    public function getRepositories()
    {
        $repos = $this->request('https://api.github.com/user/repos');

        foreach ($repos as $repo) {
            $data[] = $this->getRepositoryTemplate($repo);
        }

        return collect($data);
    }

    public function createRepository($owner, $obj)
    {
        $params = [
            'name' => str_slug($obj->title, '-'),
            'description' => $obj->description,
        ];
        $repo = $this->request('https://api.github.com/orgs/'.$owner.'/repos', true, 'POST', $params);

        return (object) $repo;
    }

    public function updateRepository($owner, $oldRepos, $obj)
    {
        $oldRepos = str_slug($oldRepos, '-');
        $params = [
            'name' => str_slug($obj->title, '-'),
            'description' => $obj->description,
        ];
        $repo = $this->request('https://api.github.com/repos/'.$owner.'/'.$oldRepos, true, 'POST', $params);

        return (object) $repo;
    }

    public function organization($login)
    {
        $orgData = $this->request('https://api.github.com/orgs/'.$login);

        if (!isset($orgData->id)) {
            $orgData = $this->request('https://api.github.com/users/'.$login);
        }

        $data = [
            'github_id' => @$orgData->id,
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

        if (!isset(Auth::user()->organizations()->where(
            'organization_id',
            $organization->id
        )->first()->id)) {
            Auth::user()->organizations()->attach($organization->id);
        }

        $this->members($orgData->login);

        return $organization->id;
    }

    public function members($org)
    {
        $members = $this->request('https://api.github.com/orgs/'.$org.'/members');
        $organization = Organization::where('username', $org)->first()->users();

        foreach ($members as $member) {
            if (isset($member->id)) {
                $data = [
                    'github_id' => $member->id,
                    'username' => $member->login,
                    'name' => $member->login,
                    'avatar' => $member->avatar_url,
                    'html_url' => $member->html_url,
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
                    $user = User::where('username', $member->login)->first();
                }

                if (!isset($organization->where('user_id', Auth::user()->id)->first()->id)) {
                    $organization->attach($user->id);
                }
            }
        }
    }

    public function setBranches($owner, $product_backlog_id, $repo)
    {
        $y = 0;
        for ($i = 1; $i > $y; ++$i) {
            $branches = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/branches?page='.$i);
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

        if ($auth) {
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

    public function setIssues($owner, $repo)
    {
        $issues = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/issues?state=all');
        $repository = Repository::where('name', $repo)->first();
        $IssueRepository = new IssueRepository();
        foreach ($issues as $issue) {
            $data = [
                'github_id' => $issue->id,
                'product_backlog_id' => $repository->id,
                'number' => $issue->number,
                'title' => $issue->title,
                'body' => $issue->body,
                'state' => $issue->state,
                'html_url' => $issue->html_url,
                'date' => $issue->created_at,
            ];
            $issueId = $IssueRepository->add($data)->id;
            foreach ($issue->assignees as $assign) {
                User::where('github_id', $assign->id)->first()->issues()->sync([$issueId], false);
            }
        }
    }

    public function issues()
    {
        return $this->request('https://api.github.com/repos/Doinn/Dracarys/issues/317');
    }

    public function setCommits($owner, $repo, $branch, $since = null)
    {
        ////repos/:owner/:repo/commits?sha=branchname
        $y = 0;
        for ($i = 1; $i > $y; ++$i) {
            $commits = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/commits?page='.$i.'&sha='.$branch.(is_null($since) ? '' : '&since='.$since));
            $branch = Branch::join('product_backlogs', 'branches.product_backlog_id', '=', 'repositories.id')
                            ->where('branches.name', $branch)
                            ->where('product_backlogs.name', $repo)
                            ->select('branches.id AS branch_id', 'repositories.id AS product_backlog_id')->first();
            $CommitRepository = new CommitRepository();
            foreach ($commits as $commit) {
                try {
                    $user = User::where('github_id', $commit->author->id)->first();
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
        $commits = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/commits/'.$sha);
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
        $commits = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/commits/'.$sha);
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
        $pulls = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/pulls');
        $repository = Repository::where('name', $repo)->first();
        $PullRequestRepository = new PullRequestRepository();
        foreach ($pulls as $pull) {
            $branch = Branch::where('name', $pull->head->ref)->first();
            try {
                $user = User::where('github_id', $pull->user->id)->first();
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
                'github_id' => $pull->id,
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

            $commits = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/pulls/'.$pull->number.'/commits');
            //dd($commits);
            foreach ($commits as $commit) {
                $c = Commit::where('sha', '=', $commit->sha)->first();
                $pull->commit()->sync([$c->id], false);
            }
        }
    }

    public function getStatsCommitActivity($owner, $repo)
    {
        ///repos/:owner/:repo/stats/contributors
        $stats = $this->request('https://api.github.com/repos/'.$owner.'/'.$repo.'/stats/commit_activity');
        $arr = [];
        foreach ($stats as $stat) {
            $arr[] = $stat->total;
        }

        return $arr;
    }
}
