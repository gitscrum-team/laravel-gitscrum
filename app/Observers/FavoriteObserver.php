<?php

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
