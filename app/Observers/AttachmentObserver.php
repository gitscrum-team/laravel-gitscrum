<?php

namespace GitScrum\Observers;

use GitScrum\Models\Status;
use GitScrum\Models\Attachment;
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
