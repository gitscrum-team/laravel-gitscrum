<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Scopes;

use Auth;
use Carbon;

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

    public function scopeIssueStatus($query)
    {
        if (isset($this->issues)) {
            $status = $this->issues->map(function ($issue) {
                return $issue->status;
            })->groupBy('slug')->all();
            
            return collect($status);
        }
    }

    public function scopeDateforHumans($query, $attributes = 'created_at')
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$attributes])->diffForHumans();
    }
}
