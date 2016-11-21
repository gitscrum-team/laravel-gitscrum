<?php
/**
 * GitScrum v0.1
 *
 * @package  GitScrum
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;

use GitScrum\Http\Requests;
use GitScrum\Models\Issue;

class IssueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug_sprint, $slug_type = null)
    {
        $issues = Issue::join('sprints', 'issues.sprint_id', 'sprints.id')
            ->join('issue_types', 'issues.issue_type_id', 'issue_types.id')
            ->where('sprints.slug', $slug_sprint);

        if (!is_null($slug_type))
            $issues->where('issue_types.slug', $slug_type);


        $issues = $issues->orderby('issues.position', 'ASC')
            ->select('issues.*')->paginate(env('APP_PAGINATE'));

        return view('issue_types.index')
            ->with('issues', $issues);
    }
}
