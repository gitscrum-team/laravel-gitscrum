<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\Label;
use GitScrum\Models\Status;
use GitScrum\Classes\Helper;
use Auth;

class LabelObserver
{
    public function creating(Label $label)
    {
        $label->slug = Helper::slug($label->title);
        $label->user_id = Auth::user()->id;
    }

    public function created(Label $label)
    {
        (new Status())->track('labels', $label);
    }
}
