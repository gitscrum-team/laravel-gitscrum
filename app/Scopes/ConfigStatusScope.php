<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

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
