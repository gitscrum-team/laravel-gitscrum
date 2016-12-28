<?php

namespace GitScrum\Scopes;

use Auth;

trait GlobalScope
{
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeUserActive($query, $user_id = null)
    {
        $user_id = is_null($user_id) ? Auth::user()->id : $user_id;
        return $query->where('user_id', $user_id);
    }
}
