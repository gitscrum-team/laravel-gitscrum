<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers;

use GitScrum\Http\Requests\UserStoryRequest;
use GitScrum\Models\UserStory;
use GitScrum\Models\ConfigPriority;
use GitScrum\Models\ProductBacklog;
use Auth;

class UserStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            $productBacklog_id = ProductBacklog::slug($slug_product_backlog)->first()->id;
        }

        $priorities = ConfigPriority::where('enabled', 1)
            ->orderby('position', 'ASC')->get();

        return view('user_stories.create')
            ->with('productBacklogs', Auth::user()->productBacklogs())
            ->with('productBacklog_id', $productBacklog_id)
            ->with('priorities', $priorities)
            ->with('action', 'Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoryRequest $request)
    {
        $userStory = UserStory::create($request->all());

        return redirect()->route('user_stories.show', ['slug' => $userStory->slug])
            ->with('success', trans('Congratulations! The User Story has been created with successfully'));
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
        $userStory = UserStory::slug($slug)
            ->with('labels')
            ->first();

        return view('user_stories.show')
            ->with('userStory', $userStory);
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
        $userStory = UserStory::slug($slug)->first();

        $priorities = ConfigPriority::where('enabled', 1)
            ->orderby('position', 'ASC')->get();

        return view('user_stories.edit')
            ->with('productBacklogs', Auth::user()->productBacklogs())
            ->with('userStory', $userStory)
            ->with('productBacklog_id', $userStory->product_backlog_id)
            ->with('priorities', $priorities)
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
    public function update(UserStoryRequest $request, $slug)
    {
        $userStory = UserStory::slug($slug)->first();
        $userStory->update($request->all());

        return back()
            ->with('success', trans('Congratulations! The User Story has been edited with successfully'));
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
