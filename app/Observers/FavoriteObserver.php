<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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
