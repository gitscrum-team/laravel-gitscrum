<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Observers;

use Auth;
use GitScrum\Classes\Helper;
use GitScrum\Models\UserStory;

class UserStoryObserver
{
    public function creating(UserStory $userStory)
    {
        $userStory->user_id = Auth::user()->id;
        $userStory->slug = Helper::slug($userStory->title);
    }
}
