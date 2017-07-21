<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers\Web;

use Illuminate\Http\Request;
use GitScrum\Models\Issue;
use GitScrum\Models\User;

class UserIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username, $slug_type = null)
    {
        $issues = Issue::join('sprints', 'issues.sprint_id', '=', 'sprints.id')
            ->join('issues_has_users', 'issues_has_users.issue_id', '=', 'issues.id')
            ->join('users', 'users.id', '=', 'issues_has_users.user_id')
            ->join('issue_types', 'issues.issue_type_id', '=', 'issue_types.id')
            ->where('users.username', $username);

        if (!is_null($slug_type)) {
            $issues = $issues->where('issue_types.slug', $slug_type);
        }

        $issues = $issues->orderby('issues.position', 'ASC')
            ->select('issues.*')->paginate(env('APP_PAGINATE'));

        $user = User::where('username', $username)
            ->where('provider', Auth::user()->provider)
            ->first();

        return view('user_issues.index')
            ->with('issues', $issues)
            ->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $members = $request->input('members');

        $issue = Issue::slug($slug)
            ->firstOrFail();

        $issue->users()->sync($members);

        if (!$request->ajax()) {
            return redirect()->back()->with('success', trans('gitscrum.updated-successfully'));
        }
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
