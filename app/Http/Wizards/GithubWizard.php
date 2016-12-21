<?php

namespace GitScrum\Http\Wizards;

use GitScrum\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GitScrum\Models\ProductBacklog;

class GithubWizard extends Controller implements WizardInterface
{
    public static function step1()
    {
        $repositories = (object) app('GithubClass')->readRepositories();
        $currentRepositories = ProductBacklog::all();

        \Session::put('GithubRepositories', $repositories);

        return view('wizard.step1')
            ->with('repositories', $repositories)
            ->with('currentRepositories', $currentRepositories)
            ->with('columns', ['checkbox', 'repository', 'organization']);
    }

    public static function step2(Request $request)
    {
        $repositories = \Session::get('GithubRepositories')->whereIn('provider_id', $request->repos);
        foreach ($repositories as $repository) {
            try {
                app('GithubClass')->readCollaborators($repository->organization_title, $repository->title);
                $product_backlog = ProductBacklog::create(get_object_vars($repository));
                app('GithubClass')->createBranches($repository->organization_title, $product_backlog->id, $repository->title);
            } catch (\Illuminate\Database\QueryException $e) {
            }
        }

        return view('wizard.step2')
            ->with('repositories', $repositories)
            ->with('columns', ['repository', 'organization']);
    }

    public static function step3()
    {
        $result = app('GithubClass')->readIssues();

        return redirect()->route('issues.index', ['slug' => 0]);
    }
}
