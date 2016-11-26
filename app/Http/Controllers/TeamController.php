<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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
