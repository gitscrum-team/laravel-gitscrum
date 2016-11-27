<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Http\Controllers;

use GitScrum\Classes\Github;

class RepositoriesController extends Controller
{
    public function update()
    {
        $github = new Github();
        $github->repositories();

        return redirect()->route('user.dashboard')
            ->with('success', _('Updated successfully'));
    }
}
