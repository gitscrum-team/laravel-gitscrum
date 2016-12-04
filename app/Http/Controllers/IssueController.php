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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if ($slug) {
            $sprint = Sprint::where('slug', $slug)
                ->with('issues.user')
                ->with('issues.users')
                ->with('issues.commits')
                ->with('issues.statuses')
                ->with('issues.status')
                ->with('issues.comments')
                ->with('issues.attachments')
                ->with('issues.type')
                ->first();

            $issues = $sprint->issues;
        } else {
            $sprint = null;
            $issues = Auth::user()->issues;
        }

        $issues = $issues->sortBy('position')->groupBy('config_status_id');

        $configStatus = configStatus::where('type', 'issue')
            ->orderby('position', 'ASC')->get();

        if (!is_null($sprint) && !count($sprint)) {
            return redirect()->route('sprints.index');
        }

        return view('issues.index')
            ->with('sprint', $sprint)
            ->with('issues', $issues)
            ->with('configStatus', $configStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug_sprint = null, $slug_user_story = null)
    {
        $issue_types = IssueType::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $issue_efforts = ConfigIssueEffort::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $userStory = $productBacklogs = null;

        if (is_null($slug_sprint) || !$slug_sprint) {
            $userStory = UserStory::where('slug', $slug_user_story)->first();
            $productBacklogs = Auth::user()->productBacklogs($userStory->product_backlog_id);
            $usersByOrganization = Organization::find($userStory->productBacklog->organization_id)->users;
        } else {
            $usersByOrganization = Organization::find(Sprint::where('slug', $slug_sprint)->first()
                ->productBacklog->organization_id)->users;
        }

        return view('issues.create')
            ->with('productBacklogs', $productBacklogs)
            ->with('userStory', $userStory)
            ->with('slug', $slug_sprint)
            ->with('issue_types', $issue_types)
            ->with('issue_efforts', $issue_efforts)
            ->with('usersByOrganization', $usersByOrganization)
            ->with('action', 'Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(IssueRequest $request)
    {
        $issue = Issue::create($request->all());

        if (is_array($request->members)) {
            $issue->users()->sync($request->members);
        }

        return redirect()->route('issues.show', ['slug' => $issue->slug])
            ->with('success', _('Congratulations! The Issue has been created with successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $issue = Issue::where('slug', '=', $slug)
            ->with('sprint')
            ->with('type')
            ->with('configEffort')
            ->with('labels')
            ->first();

        $usersByOrganization = Organization::find($issue->productBacklog->organization_id)->users;

        $configStatus = configStatus::where('type', 'issue')
            ->orderby('position', 'ASC')->get();

        return view('issues.show')
            ->with('issue', $issue)
            ->with('usersByOrganization', $usersByOrganization)
            ->with('configStatus', $configStatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $issue = Issue::where('slug', '=', $slug)->first();

        $issue_types = IssueType::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $issue_efforts = ConfigIssueEffort::where('enabled', 1)
            ->orderby('position', 'ASC')
            ->get();

        $usersByOrganization = Organization::find($issue->productBacklog->organization_id)->users;

        return view('issues.edit')
            ->with('userStory', $issue->userStory)
            ->with('slug', isset($issue->sprint->slug) ? $issue->sprint->slug : null)
            ->with('issue_types', $issue_types)
            ->with('issue_efforts', $issue_efforts)
            ->with('usersByOrganization', $usersByOrganization)
            ->with('issue', $issue)
            ->with('action', 'Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(IssueRequest $request, $slug)
    {
        $issue = Issue::where('slug', '=', $slug)->first();
        $issue->update($request->all());

        if (is_array($request->members)) {
            $issue->users()->sync($request->members);
        }

        return back()
            ->with('success', _('Congratulations! The Issue has been edited with successfully'));
    }

    public function statusUpdate(Request $request, $slug=null, int $status=0)
    {
        if (!$request->ajax()) {
            $issue = Issue::where('slug', $slug)
                ->firstOrFail();

            $issue->config_status_id = $status;
            $issue->closed_user_id = Auth::id();
            $issue->closed_at = Carbon::now();
            $issue->save();

            return back()->with('success', _('Updated successfully'));
        } else {

            $position = 0;

            foreach(json_decode($request->json) as $id){
                $issue = Issue::find($id);
                $issue->config_status_id = $request->status_id;
                $issue->closed_user_id = Auth::id();
                $issue->closed_at = Carbon::now();
                $issue->position = $position++;
                $issue->save();
            }
            return true;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $issue = Issue::where('slug', $slug)->firstOrFail();

        if (isset($issue->userStory)) {
            $redirect = redirect()->route('user_stories.show', ['slug' => $issue->userStory->slug]);
        } else {
            $redirect = redirect()->route('sprints.show', ['slug' => $issue->sprint->slug]);
        }

        $issue->delete();

        return $redirect;
    }
}
