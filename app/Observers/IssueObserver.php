<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\{Issue,UserStory,ConfigStatus,Sprint,Status};
use GitScrum\Classes\Helper;
use Auth;

class IssueObserver
{
    public function creating(Issue $issue)
    {
        if (!isset($issue->product_backlog_id)) {
            try {
                $issue->product_backlog_id = UserStory::find($issue->user_story_id)->product_backlog_id;
            } catch (\Exception $e) {
                $issue->product_backlog_id = Sprint::find($issue->sprint_id)->product_backlog_id;
            }
        }

        $issue->slug = Helper::slug($issue->title);

        if (!isset($issue->user_id)) {
            $issue->user_id = Auth::user()->id;
        }

        if (!isset($issue->config_status_id)) {
            $issue->config_status_id = ConfigStatus::where('default', '=', 1)->first()->id;
        }

        $issue->sprint_id = intval($issue->sprint_id)?$issue->sprint_id:null;

        $tmp = app(Auth::user()->provider)->createOrUpdateIssue($issue);
        if (isset($tmp->id)) {
            $issue->provider_id = $tmp->id;
            $issue->number = $tmp->number;
        }

        $issue->provider = strtolower(Auth::user()->provider);

        // TODO Create a branch in GitHub
        //$model->branch->sync([['sprint_id' => true]]);
    }

    public function created($issue)
    {
        (new Status())->track('issues', $issue);
    }

    public function updating($issue)
    {
        if (isset($issue->number)) {
            app(Auth::user()->provider)->createOrUpdateIssue($issue);
        }
        (new Status())->track('issues', $issue);
    }

    public function deleting(Issue $issue)
    {
        $issue->comments()->delete();
        $issue->attachments()->delete();
        $issue->notes()->delete();
        $issue->statuses()->delete();
        $issue->favorite()->delete();
    }
}
