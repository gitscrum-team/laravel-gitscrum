<?php

namespace GitScrum\Observers;

use GitScrum\Models\Status;
use GitScrum\Models\Comment;
use Auth;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        $comment->user_id = Auth::user()->id;

        if ($comment->commentable_type == 'issues') {
            $tmp = app(Auth::user()->provider)->createOrUpdateIssueComment($comment);
            $comment->provider_id = $tmp->id;
        }
    }

    public function created(Comment $comment)
    {
        (new Status())->track('comments', $comment);
    }

    public function updated(Comment $comment)
    {
        if ($comment->commentable_type == 'issue') {
            app(Auth::user()->provider)->createOrUpdateIssueComment($comment);
        }
    }

    public function deleted(Comment $comment)
    {
        $statuses = $comment->statuses->first();
        Status::destroy($statuses->id);

        if ($comment->commentable_type == 'issue') {
            app(Auth::user()->provider)->deleteIssueComment($comment);
        }
    }
}
