<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers;

use Auth;

class TeamController extends Controller
{
    public function index()
    {
        return view('teams.index')
            ->with('list', Auth::user()->team());
    }
}
