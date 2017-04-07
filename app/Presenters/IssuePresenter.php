<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Presenters;

use GitScrum\Classes\Parsedown;
use GitScrum\Models\ConfigStatus;

trait IssuePresenter
{
    public function getNumberAttribute()
    {
        return isset($this->attributes['number']) ? $this->attributes['number'] : null;
    }

    public function getStatusAvailableAttribute()
    {
        return ConfigStatus::type('issues')->get();
    }

    public function getSprintSlugAttribute()
    {
        return isset($this->sprint->slug) ? $this->sprint->slug : 0;
    }

    public function getSprintClosedAttribute()
    {
        return isset($this->sprint->closed_at) ? $this->sprint->closed_at : null;
    }

    public function getDescriptionAttribute()
    {
        $parsedown = new Parsedown;
        return $parsedown->text($this->attributes['description']);
    }

    public function getMarkdownDescriptionAttribute()
    {
        return $this->attributes['description'];
    }
}
