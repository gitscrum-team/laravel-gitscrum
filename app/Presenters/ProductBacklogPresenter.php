<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Presenters;

trait ProductBacklogPresenter
{
    public function getVisibilityAttribute()
    {
        return $this->attributes['is_private'] ? trans('Private') : trans('Public');
    }
}
