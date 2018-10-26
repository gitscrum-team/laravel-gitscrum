<?php

namespace GitScrum\Http\Controllers\Web;

use Illuminate\Http\Request;
use GitScrum\Contracts\SlackInterface as Slack;
use GitScrum\Http\Requests\IssueRequest;
use GitScrum\Models\Sprint;
use GitScrum\Models\Issue;
use GitScrum\Models\Organization;
use GitScrum\Models\ConfigStatus;
use Carbon\Carbon;
use Auth;
use GitScrum\Http\Responses\Issue\Store as IssueStoreResponse;

class IssueController extends Controller
{
    public function index($slug)
    {
        [$sprint,$issues] = $this->sprintWithIssues($slug);

        if (!is_null($sprint) && ! $sprint) {
            return redirect()->route('sprints.index');
        }

        return view('issues.index')
            ->with('sprint', $sprint)
            ->with('issues', $issues->sortBy('position')->groupBy('config_status_id'))
            ->with('configStatus', ConfigStatus::type('issues')->get());
    }

    private function sprintWithIssues($slug)
    {
        if ($slug) {
            $sprint = $this->eagerLoad(Sprint::slug($slug), 'issues.')->first();

            return [$sprint , $sprint->issues];
        }

        return [ null , $this->eagerLoad(Auth::user()->issues())->get()];
    }

    private function eagerLoad($query, $relation = '')
    {
        $eagerLoaders = collect(['user','users','commits','statuses',
                                 'comments','attachments','type',
                                 'productBacklog','sprint','configEffort']);

        $eagerLoaders->each(function ($loader) use (&$query, $relation) {
            $query = $query->with($relation . $loader);
        });

        return $query;
    }

    public function create($scope, $slug, $parent_id = null)
    {
        $model = 'GitScrum\\Models\\'.$scope;

        $obj = $model::slug($slug)->first();
        $organization = Organization::find($obj->productBacklog->organization_id);

        return view('issues.create')
            ->with('relation', with(new $model)->getTable())
            ->with('obj', $obj)
            ->with('organization', $organization)
            ->with('parent_id', $parent_id)
            ->with('action', 'Create');
    }

    public function store(IssueRequest $request)
    {
        $issue = resolve('IssueService')->create($request);

        return (new IssueStoreResponse())->response($request, $issue);
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
        $obj = $issue = Issue::slug($slug)->first();

        $organization = Organization::find($issue->productBacklog->organization_id);

        return view('issues.edit')
            ->with('relation', 'issue')
            ->with('issue', $issue)
            ->with('obj', $obj)
            ->with('organization', $organization)
            ->with('parent_id', $issue->parent_id)
            ->with('action', 'Edit');
    }

    public function update(IssueRequest $request, $slug)
    {
        resolve('IssueService')->update($request);

        return back()
            ->with('success', trans('gitscrum.congratulations-the-issue-has-been-edited-with-successfully'));
    }

    public function statusUpdate(Request $request, Slack $slack, $slug = null, $status = 0)
    {
        $request->status_id = $request->status_id ?? $status;

        if ($request->ajax()) {
            $status = false;

            if ($response = resolve('IssueService')->setRequest($request)
                ->updateStatusByJson()) {
                $status = true;
            }

            return response()->json([
                'success' => $status,
            ]);
        }

        $request->slug = $slug;
        
        resolve('IssueService')->setRequest($request)->updateStatus();

        $issue = Issue::slug($slug)->firstOrFail();

        $content = [
            'title' => "{$issue->title}",
            'url' => url("issues/status-update/{$slug}"),
            'updated_by' => Auth::user()->slack_username,
            'status' => $status,
        ];

        $slack->send($content, 2);

        return back()->with('success', trans('gitscrum.updated-successfully'));
    }

    public function destroy(Request $request)
    {
        $issue = Issue::slug($request->slug)->firstOrFail();

        [$route, $params] = ['sprints.show',
                            ['slug' => $issue->sprint->slug]];

        if (isset($issue->userStory)) {
            [$route, $params] = ['user_stories.show',
                                ['slug' => $issue->userStory->slug]];
        }

        $issue->delete();

        return redirect()->route($route, $params);
    }
}
