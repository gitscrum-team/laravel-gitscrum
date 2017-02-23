<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Observers;

use GitScrum\Models\{Status,Attachment};
use Auth;

class AttachmentObserver
{
    public function creating(Attachment $attachment)
    {
        $attachment->user_id = Auth::user()->id;
    }

    public function created(Attachment $attachment)
    {
        (new Status())->track('attachments', $attachment);
    }
}
