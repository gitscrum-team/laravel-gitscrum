<?php
/**
 * GitScrum v0.1
 *
 * @package  GitScrum
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Observers;

use GitScrum\Models\UserStory;
use GitScrum\Classes\Helper;
use Auth;

class UserStoryObserver
{

    public function creating(UserStory $userStory)
    {
        $userStory->user_id = Auth::user()->id;
        $userStory->slug = Helper::slug($userStory->title);
    }

}
