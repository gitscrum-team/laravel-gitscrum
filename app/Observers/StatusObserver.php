<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\Status;
use Auth;

class StatusObserver
{
    public function creating(Status $status)
    {
        $status->delete();
        $status->user_id = Auth::user()->id;
    }
}
