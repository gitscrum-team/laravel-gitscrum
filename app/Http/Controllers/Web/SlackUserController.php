<?php

namespace GitScrum\Http\Controllers\Web;

use Auth;
use Illuminate\Http\Request;

class SlackUserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     */
    public function update(Request $request)
    {
    	$user = Auth::user();
    	$user->slack_username = $request->slack_username;
    	$user->save();

    	return back()->with('success', trans('gitscrum.updated-successfully'));
    }
}
