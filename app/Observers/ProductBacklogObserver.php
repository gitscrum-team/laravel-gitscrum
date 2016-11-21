<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Observers;

use GitScrum\Models\ProductBacklog;
use GitScrum\Classes\Helper;
use Auth;

class ProductBacklogObserver
{
    public function creating(ProductBacklog $productBacklog)
    {
        $productBacklog->user_id = Auth::user()->id;
        $productBacklog->slug = Helper::slug($productBacklog->title);
    }
}
