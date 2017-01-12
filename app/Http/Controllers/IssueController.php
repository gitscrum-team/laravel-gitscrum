<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Http\Requests\IssueRequest;
use GitScrum\Models\Sprint;
use GitScrum\Models\UserStory;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\IssueType;
use GitScrum\Models\ConfigStatus;
use GitScrum\Models\ConfigIssueEffort;
use Carbon\Carbon;
use Auth;

class IssueController extends Controller
{
    public function index($slug)
    {
        if ($slug) {
            $sprint = Sprint::slug($slug)
                ->with('issues.user')
                ->with('issues.users')
                ->with('issues.commits')
                ->with('issues.statuses')
                ->with('issues.status')
                ->with('issues.comments')
                ->with('issues.attachments')
                ->with('issues.type')
                ->with('issues.productBacklog')
                ->with('issues.sprint')
                ->with('issues.configEffort')
                ->first();

            $issues = $sprint->issues;
        } else {
            $sprint = null;
            $issues = Auth::user()->issues()
                ->with('user')
                ->with('users')
                ->with('commits')
                ->with('statuses')
                ->with('status')
                ->with('comments')
                ->with('attachments')
                ->with('type')
                ->with('productBacklog')
                ->with('sprint')
                ->with('configEffort')
                ->get();
        }

        $issues = $issues->sortBy('position')->groupBy('config_status_id');

        $configStatus = ConfigStatus::type('issue')->get();

        if (!is_null($sprint) && !count($sprint)) {
            return redirect()->route('sprints.index');
        }

        return view('issues.index')
            ->with('sprint', $sprint)
            ->with('issues', $issues)
            ->with('configStatus', $configStatus);
    }

    public function create($slug_sprint = null, $slug_user_story = null, $parent_id = null)
    {
        $issue_types = IssueType::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $issue_efforts = ConfigIssueEffort::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $userStory = $productBacklogs = null;

        if ((is_null($slug_sprint) || !$slug_sprint) && $slug_user_story) {
            $userStory = UserStory::slug($slug_user_story)->first();
            $productBacklogs = Auth::user()->productBacklogs($userStory->product_backlog_id);
            $usersByOrganization = Organization::find($userStory->productBacklog->organization_id)->users;
        } elseif ($slug_sprint) {
            $usersByOrganization = Organization::find(Sprint::slug($slug_sprint)->first()
                ->productBacklog->organization_id)->users;
        } else {
            $issue = Issue::find($parent_id);
            $productBacklogs = $issue->product_backlog_id;
            $usersByOrganization = Organization::find($issue->productBacklog->organization_id)->users;
        }

        return view('issues.create')
            ->with('productBacklogs', $productBacklogs)
            ->with('userStory', $userStory)
            ->with('slug', $slug_sprint)
            ->with('parent_id', $parent_id)
            ->with('issue_types', $issue_types)
            ->with('issue_efforts', $issue_efforts)
            ->with('usersByOrganization', $usersByOrganization)
            ->with('action', 'Create');
    }

    public function store(IssueRequest $request)
    {
        $issue = Issue::create($request->all());

        if (is_array($request->members)) {
            $issue->users()->sync($request->members);
        }

        return redirect()->route('issues.show', ['slug' => $issue->slug])
            ->with('success', trans('Congratulations! The Issue has been created with successfully'));
    }

    public function show($slug)
    {
        $issue = Issue::slug($slug)
            ->with('sprint')
            ->with('type')
            ->with('configEffort')
            ->with('labels')
            ->first();

        $usersByOrganization = Organization::find($issue->productBacklog->organization_id)->users;

        return view('issues.show')
            ->with('issue', $issue)
            ->with('usersByOrganization', $usersByOrganization);
    }

    public function edit($slug)
    {
        $issue = Issue::slug($slug)->first();

        $issue_types = IssueType::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $issue_efforts = ConfigIssueEffort::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $usersByOrganization = Organization::find($issue->productBacklog->organization_id)->users;

        return view('issues.edit')
            ->with('productBacklogs', $issue->productBacklog->id)
            ->with('userStory', $issue->userStory)
            ->with('slug', isset($issue->sprint->slug) ? $issue->sprint->slug : null)
            ->with('issue_types', $issue_types)
            ->with('issue_efforts', $issue_efforts)
            ->with('usersByOrganization', $usersByOrganization)
            ->with('issue', $issue)
            ->with('action', 'Edit');
    }

    public function update(IssueRequest $request, $slug)
    {
        $issue = Issue::slug($slug)->first();
        $issue->update($request->all());

        if (is_array($request->members)) {
            $issue->users()->sync($request->members);
        }

        return back()
            ->with('success', trans('Congratulations! The Issue has been edited with successfully'));
    }

    public function statusUpdate(Request $request, $slug = null, int $status = 0)
    {
        if (!isset($request->status_id)) {
            $request->status_id = $status;
        }
        $status = ConfigStatus::find($request->status_id);
        $save = function ($issue, $position = null) use ($request, $status) {
            $issue->config_status_id = $request->status_id;

            if (!is_null($status->is_closed) && is_null($issue->closed_at)) {
                $issue->closed_user_id = Auth::id();
                $issue->closed_at = Carbon::now();
            } elseif (is_null($status->is_closed)) {
                $issue->closed_user_id = null;
                $issue->closed_at = null;
            }

            if ($position) {
                $issue->position = $position;
            }

            return $issue->save();
        };

        if ($request->ajax()) {
            $position = 1;
            try {
                foreach (json_decode($request->json) as $id) {
                    $issue = Issue::find($id);
                    $save($issue, $position);
                    ++$position;
                }

                return response()->json([
                    'success' => true,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                ]);
            }
        } else {
            $issue = Issue::slug($slug)
                ->firstOrFail();
            $save($issue);

            return back()->with('success', trans('Updated successfully'));
        }
    }

    public function destroy(Request $request)
    {
        $issue = Issue::slug($request->slug)->firstOrFail();

        if (isset($issue->userStory)) {
            $redirect = redirect()->route('user_stories.show', ['slug' => $issue->userStory->slug]);
        } else {
            $redirect = redirect()->route('sprints.show', ['slug' => $issue->sprint->slug]);
        }

        $issue->delete();

        return $redirect;
    }
}
