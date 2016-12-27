<?php

namespace GitScrum\Scopes;

trait ConfigStatusScope
{
	public function scopeType($query, $type)
    {
        return $query->where('type', $type)->orderby('position', 'ASC');
    }

    public function scopeDefault($query)
    {
        return $query->where('default', 1);
    }
}
