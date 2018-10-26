<?php

namespace GitScrum\Presenters;

use Carbon\Carbon;

trait GlobalPresenter
{
    public function dateforHumans($attributes = 'created_at')
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes[$attributes])->diffForHumans();
    }
}
