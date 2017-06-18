<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

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
