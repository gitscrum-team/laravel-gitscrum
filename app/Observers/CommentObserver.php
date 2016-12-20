<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Observers;

use GitScrum\Models\Status;
use GitScrum\Models\Comment;
use Auth;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        $comment->user_id = Auth::user()->id;

        if ($comment->commentable_type == 'issue') {
            $tmp = app('GithubClass')->createOrUpdateIssueComment($comment);
            $comment->provider_id = $tmp->id;
        }
    }

    public function created(Comment $comment)
    {
        (new Status())->track('comment', $comment);
    }

    public function updated(Comment $comment)
    {
        if ($comment->commentable_type == 'issue') {
            app('GithubClass')->createOrUpdateIssueComment($comment);
        }
    }

    public function deleted(Comment $comment)
    {
        $statuses = $comment->statuses->first();
        Status::destroy($statuses->id);

        if ($comment->commentable_type == 'issue') {
            app('GithubClass')->deleteIssueComment($comment);
        }
    }
}
