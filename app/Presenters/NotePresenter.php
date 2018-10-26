<?php

namespace GitScrum\Presenters;

trait NotePresenter
{
    public function setClosedUserIdAttribute($value)
    {
        $this->attributes['closed_user_id'] = is_null($this->closed_at) ? $value : null;
    }

    public function setClosedAtAttribute($value)
    {
        $this->attributes['closed_at'] = is_null($this->closed_at) ? $value : null;
    }
}
