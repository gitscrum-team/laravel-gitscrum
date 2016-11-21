<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Http\Requests\ProductBacklogRequest;
use GitScrum\Models\ProductBacklog;
use Auth;

class ProductBacklogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mode = 'default')
    {
        return view('product_backlogs.index-'.$mode)
            ->with('backlogs', Auth::user()->productBacklogs());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product_backlogs.create')
            ->with('action', 'Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductBacklogRequest $request)
    {
        $productBacklog = ProductBacklog::create($request->all());

        return redirect()->route('product_backlogs.show', ['slug' => $productBacklog->slug])
            ->with('success', _('Congratulations! The Product Backlog has been created with successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $productBacklog = ProductBacklog::where('slug', $slug)
            ->with('sprints')
            ->with('userStories')
            ->first();

        $sprints = $productBacklog->sprints()
            ->with('productBacklog')
            ->with('favorite')
            ->with('issues.users')
            ->with('issues')
            ->paginate(env('APP_PAGINATE'));

        $userStories = $productBacklog->userStories();

        if ($request->user_story) {
            $userStories->where('title', 'like', '%'.$request->user_story.'%');
            $search = $request->user_story;
        }

        $userStories = $userStories->with('issues')
            ->paginate(env('APP_PAGINATE'));

        return view('product_backlogs.show')
            ->with('productBacklog', $productBacklog)
            ->with('sprints', $sprints)
            ->with('userStories', $userStories)
            ->with('search', (!isset($search)) ? null : $search);
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
        $productBacklog = ProductBacklog::where('slug', '=', $slug)->first();

        return view('product_backlogs.edit')
            ->with('productBacklog', $productBacklog)
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
    public function update(ProductBacklogRequest $request, $slug)
    {
        $productBacklog = ProductBacklog::where('slug', '=', $slug)->first();
        $productBacklog->update($request->all());

        return redirect()->route('product_backlogs.show', ['slug' => $productBacklog->slug])
            ->with('success', _('Congratulations! The Product Backlog has been edited with successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
