<?php

namespace GitScrum\Scopes;

trait GlobalScope
{
	public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
