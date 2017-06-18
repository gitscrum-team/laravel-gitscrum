<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Presenters;

trait CommitFilePresenter
{
    public function getAdditionsAttribute()
    {
        return $this->attributes['additions'] !== null ? $this->attributes['additions'] : 0;
    }

    public function getChangesAttribute()
    {
        return $this->attributes['changes'] !== null ? $this->attributes['changes'] : 0;
    }

    public function getDeletionsAttribute()
    {
        return $this->attributes['deletions'] !== null ? $this->attributes['deletions'] : 0;
    }
}
