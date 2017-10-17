<?php

namespace GitScrum\Observers;

use GitScrum\Models\Branch;
use Auth;

class BranchObserver
{
    public function creating(Branch $branch)
    {
        $branch->user_id = Auth::user()->id;
    }
}
