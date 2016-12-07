<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Observers;

use GitScrum\Models\Issue;
use GitScrum\Models\UserStory;
use GitScrum\Models\ConfigStatus;
use GitScrum\Models\Sprint;
use GitScrum\Models\Status;
use GitScrum\Classes\Helper;
use Auth;

class IssueObserver
{
    public function creating(Issue $issue)
    {
        if (isset($issue->product_backlog_id)) {
            $product_backlog_id = $issue->product_backlog_id;
        } else {
            try {
                $product_backlog_id = UserStory::find($issue->user_story_id)->product_backlog_id;
            } catch (\Exception $e) {
                $product_backlog_id = $issue->sprint()->first()->product_backlog_id;
            }
        }

        $issue->slug = Helper::slug($issue->title);

        if (!isset($issue->user_id)) {
            $issue->user_id = Auth::user()->id;
        }

        if (!isset($issue->config_status_id)) {
            $issue->config_status_id = ConfigStatus::where('default', '=', 1)->first()->id;
        }

        $issue->product_backlog_id = $product_backlog_id;

        // TODO Create a branch in GitHub
        //$model->branch->sync([['sprint_id' => true]]);
    }

    public function created($issue)
    {
        (new Status())->track('issue', $issue);
    }

    public function updating($issue)
    {
        (new Status())->track('issue', $issue);
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
