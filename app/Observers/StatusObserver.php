<?php

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
