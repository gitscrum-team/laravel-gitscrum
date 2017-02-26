<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
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
