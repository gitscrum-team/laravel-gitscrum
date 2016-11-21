<?php
/**
 * GitScrum v0.1
 *
 * @package  GitScrum
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Observers;

use GitScrum\Models\Label;
use GitScrum\Classes\Helper;
use Auth;

class LabelObserver
{

    public function creating(Label $label)
    {
        $label->slug = Helper::slug($label->title);
        $label->user_id = Auth::user()->id;
    }

}
