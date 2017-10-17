<?php

namespace GitScrum\Http\Controllers\Web;

use Auth;

class TeamController extends Controller
{
    public function index()
    {
        return view('teams.index')
            ->with('list', Auth::user()->team());
    }
}
