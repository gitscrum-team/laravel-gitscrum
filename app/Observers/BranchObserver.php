<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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
