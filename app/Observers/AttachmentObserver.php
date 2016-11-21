<?php
/**
 * GitScrum v0.1
 *
 * @package  GitScrum
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Observers;

use GitScrum\Models\Attachment;
use Auth;

class AttachmentObserver
{

    public function creating(Attachment $attachment)
    {
        $attachment->user_id = Auth::user()->id;
    }

}
