<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers;

use GitScrum\Http\Requests\SprintRequest;
use GitScrum\Models\ConfigStatus;
use GitScrum\Models\ProductBacklog;
use GitScrum\Models\Sprint;
use Auth;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mode = 'default', $slug_product_backlog = null)
    {
        $sprints = Sprint::orderby('date_start', 'DESC')
            ->orderby('date_finish', 'ASC');

        if (!is_null($slug_product_backlog)) {
            $sprints = $sprints->join('product_backlogs', 'product_backlogs.id', 'sprints.product_backlog_id')
                ->where('product_backlogs.slug', $slug_product_backlog);
        }

        $sprints = $sprints->with('issues')
            ->with('favorite')
            ->with('status')
            ->select('sprints.*')
            ->paginate(env('APP_PAGINATE'));

        return view('sprints.index-'.$mode)
            ->with('sprints', $sprints);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug_product_backlog = null)
    {
        $productBacklog_id = null;

        if (!is_null($slug_product_backlog)) {
            $productBacklog_id = ProductBacklog::where('slug', $slug_product_backlog)->first()->id;
        }

        return view('sprints.create')
            ->with('productBacklogs', Auth::user()->productBacklogs())
            ->with('productBacklog_id', $productBacklog_id)
            ->with('action', 'Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GitScrum\Http\Requests\SprintRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SprintRequest $request)
    {
        $sprint = Sprint::create($request->all());

        return redirect()->route('sprints.show', ['slug' => $sprint->slug])
            ->with('success', trans('Congratulations! The Sprint has been created with successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param str $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $sprint = Sprint::where('slug', $slug)
            ->with('issues.user')
            ->with('issues.users')
            ->with('issues.commits')
            ->with('branches.user')
            ->with('branches.commits')
            ->with('branches.commits.files')
            ->with('issues.statuses')
            ->with('issues.statuses.configStatus')
            ->with('issues.statuses.configStatus.users')
            ->with('issues.statuses.user')
            ->with('issues.statuses.statusesable')
            ->with('notes')
            ->first();

        if (!count($sprint)) {
            return redirect()->route('sprints.index');
        }

        $configStatus = ConfigStatus::type('sprint')->get();

        return view('sprints.show')
            ->with('sprint', $sprint)
            ->with('configStatus', $configStatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function edit($slug)
    {
        $sprint = Sprint::where('slug', '=', $slug)->first();

        return view('sprints.edit')
            ->with('action', 'Edit')
            ->with('sprint', $sprint);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SprintRequest|Request $request
     * @param $slug
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function update(SprintRequest $request, $slug)
    {
        $sprint = Sprint::where('slug', '=', $slug)->first();
        $sprint->update($request->all());

        return back()
            ->with('success', trans('Congratulations! The Sprint has been edited with successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function destroy(Request $request)
    {
        $sprint = Sprint::where('slug', '=', $request->input('slug'))->first();

        if (!count($sprint)) {
            return redirect()->route('sprints.index');
        }

        $sprint->delete();

        return redirect()->route('sprints.index')
            ->with('success', trans('Congratulations! The Sprint has been deleted successfully'));
    }
}
