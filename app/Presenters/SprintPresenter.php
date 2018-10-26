<?php

namespace GitScrum\Presenters;

use Carbon;

trait SprintPresenter
{
    public function getVisibilityAttribute()
    {
        return $this->attributes['is_private'] ? trans('Private') : trans('Public');
    }

    public function getSlugAttribute()
    {
        return isset($this->attributes['slug']) ? $this->attributes['slug'] : '';
    }

    public function getTimeboxAttribute()
    {
        $date_start = isset($this->attributes['date_start']) ?
            Carbon::parse($this->attributes['date_start'])->toDateString() : '';
        $date_finish = isset($this->attributes['date_finish']) ?
            Carbon::parse($this->attributes['date_finish'])->toDateString() : '';

        return $date_start.' '.trans('to').' '.$date_finish;
    }
}
