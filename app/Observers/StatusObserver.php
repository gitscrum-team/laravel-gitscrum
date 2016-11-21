<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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
