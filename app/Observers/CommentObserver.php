<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Observers;

use Auth;
use GitScrum\Models\Comment;
use GitScrum\Models\Status;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        $comment->user_id = Auth::user()->id;
    }

    public function created(Comment $comment)
    {
        (new Status())->track('comment', $comment);
    }

    public function deleted(Comment $comment)
    {
        $statuses = $comment->statuses->first();
        Status::destroy($statuses->id);
    }
}
