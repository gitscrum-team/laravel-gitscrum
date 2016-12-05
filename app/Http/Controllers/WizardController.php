<?php

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Models\ProductBacklog;

class WizardController extends Controller
{
    public function step1()
    {
        $repositories = (object) app('GithubClass')->getRepositories();
        $currentRepositories = ProductBacklog::all();

        \Session::put('GithubRepositories', $repositories);

        return view('wizard.step1')
            ->with('repositories', $repositories)
            ->with('currentRepositories', $currentRepositories)
            ->with('columns', ['checkbox', 'repository', 'organization']);
    }

    public function step2(Request $request)
    {
        $repositories = \Session::get('GithubRepositories')->whereIn('github_id', $request->repos);
        foreach ($repositories as $repository) {
            try {
                $product_backlog = ProductBacklog::create(get_object_vars($repository));
                app('GithubClass')->setBranches($repository->organization_title, $product_backlog->id, $repository->title);
            } catch (\Illuminate\Database\QueryException $e) {
            }
        }

        return view('wizard.step2')
            ->with('repositories', $repositories)
            ->with('columns', ['repository', 'organization']);
    }
}
