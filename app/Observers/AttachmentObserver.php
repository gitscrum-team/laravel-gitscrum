<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Observers;

use Auth;
use GitScrum\Models\Attachment;
use GitScrum\Models\Status;

class AttachmentObserver
{
    public function creating(Attachment $attachment)
    {
        $attachment->user_id = Auth::user()->id;
    }

    public function created(Attachment $attachment)
    {
        (new Status())->track('attachment', $attachment);
    }
}
