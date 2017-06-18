<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Http\Requests\UserStoryRequest;
use GitScrum\Models\UserStory;
use GitScrum\Models\ConfigPriority;
use GitScrum\Models\ProductBacklog;
use GitScrum\Classes\Helper;
use Auth;

class UserStoryController extends Controller
{
    public function index(Request $request)
    {
        $userStories = Helper::lengthAwarePaginator(Auth::user()->userStories(), $request->page);
        return view('user_stories.index')
            ->with('userStories', $userStories);
    }

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

    public function store(UserStoryRequest $request)
    {
        $userStory = UserStory::create($request->all());

        return redirect()->route('user_stories.show', ['slug' => $userStory->slug])
            ->with('success', trans('gitscrum.congratulations-the-user-story-has-been-created-with-successfully'));
    }

    public function show($slug)
    {
        $userStory = UserStory::slug($slug)
            ->with('labels')
            ->first();
            
        return view('user_stories.show')
            ->with('userStory', $userStory);
    }

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

    public function update(UserStoryRequest $request, $slug)
    {
        $userStory = UserStory::slug($slug)->first();
        $userStory->update($request->all());

        return back()
            ->with('success', trans('gitscrum.congratulations-the-user-story-has-been-updated-with-successfully'));
    }

    public function destroy(Request $request)
    {
        $userStory = UserStory::slug($request->slug)->firstOrFail();
        $userStory->delete();

        return redirect()->route('product_backlogs.index');
    }
}
