<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers;

use GitScrum\Models\ProductBacklog;
use Request;
use Session;
use Auth;

class WizardController extends Controller
{
    public function step1()
    {
        $repositories = (object) app(Auth::user()->provider)->readRepositories();
        $currentRepositories = ProductBacklog::all();

        Session::put('Repositories', $repositories);

        return view('wizard.step1')
            ->with('repositories', $repositories)
            ->with('currentRepositories', $currentRepositories)
            ->with('columns', ['checkbox', 'repository', 'organization']);
    }

    public function step2(Request $request)
    {
        $repositories = Session::get('Repositories')->whereIn('provider_id', $request->repos);
        foreach ($repositories as $repository) {
            app(Auth::user()->provider)->readCollaborators($repository->organization_title, $repository->title, $repository->provider_id);
            $product_backlog = ProductBacklog::where('provider_id', $repository->provider_id)->first();
            if (!isset($product_backlog)) {
                $product_backlog = ProductBacklog::create(get_object_vars($repository));
            }
            app(Auth::user()->provider)->createBranches($repository->organization_title, $product_backlog->id, $repository->title, $repository->provider_id);
        }

        return view('wizard.step2')
            ->with('repositories', $repositories)
            ->with('columns', ['repository', 'organization']);
    }

    public function step3()
    {
        $result = app(Auth::user()->provider)->readIssues();

        return redirect()->route('issues.index', ['slug' => 0]);
    }
}
