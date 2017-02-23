<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\{Note,Status};
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
