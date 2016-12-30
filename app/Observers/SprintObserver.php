<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Observers;

use GitScrum\Models\Sprint;
use GitScrum\Models\ConfigStatus;
use GitScrum\Classes\Helper;
use Carbon\Carbon;
use Auth;

class SprintObserver
{
    public function creating(Sprint $sprint)
    {
        $sprint->user_id = Auth::user()->id;
        $sprint->slug = Helper::slug($sprint->title);

        $configStatus = ConfigStatus::type('sprint')->default()->first();
        
        if ( $configStatus->is_closed ) {
            $sprint->closed_at = Carbon::now();
        }

        $sprint->config_status_id = $configStatus->id;
    }

    public function updating(Sprint $sprint)
    {
        $is_closed = ConfigStatus::find($sprint->config_status_id)->is_closed;
        $sprint->closed_at = null;

        if ( $is_closed ) {
            $sprint->closed_at = Carbon::now();
        }
    }
}
