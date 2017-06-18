<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\Favorite;
use Auth;

class FavoriteObserver
{
    public function creating(Favorite $favorite)
    {
        $favorite->user_id = Auth::user()->id;
    }
}
