<?php

namespace GitScrum\Observers;

use GitScrum\Models\Note;
use GitScrum\Models\Status;
use GitScrum\Classes\Helper;
use Auth;

class NoteObserver
{
    public function creating(Note $note)
    {
        $note->user_id = Auth::user()->id;
        $note->slug = Helper::slug($note->title);
    }

    public function created(Note $note)
    {
        (new Status())->track('notes', $note);
    }
}
