<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\UserStory;
use GitScrum\Classes\Helper;
use Auth;

class UserStoryObserver
{
    public function creating(UserStory $userStory)
    {
        if (!isset($userStory->user_id)) {
            $userStory->user_id = Auth::user()->id;
        }

        $userStory->slug = Helper::slug($userStory->title);
    }

    public function deleting(UserStory $userStory)
    {
        $userStory->comments()->delete();
        $userStory->issues()->delete();
        $userStory->notes()->delete();
        $userStory->labels()->delete();
        $userStory->favorite()->delete();
    }
}
