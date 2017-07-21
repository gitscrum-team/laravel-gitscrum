<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Presenters;

use Carbon\Carbon;

trait GlobalPresenter
{
    public function dateforHumans($attributes = 'created_at')
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$attributes])->diffForHumans();
    }
}
