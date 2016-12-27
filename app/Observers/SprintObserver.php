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
use Auth;

class SprintObserver
{
    public function creating(Sprint $sprint)
    {
        $sprint->user_id = Auth::user()->id;
        $sprint->slug = Helper::slug($sprint->title);
        $sprint->config_status_id = ConfigStatus::type('sprint')->default()->first()->id;
    }
}
