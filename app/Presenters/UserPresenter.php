<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Presenters;

trait UserPresenter
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ?? $this->attributes['username'];
    }

    public function getProviderAttribute()
    {
        return ucfirst($this->attributes['provider']);
    }
}
