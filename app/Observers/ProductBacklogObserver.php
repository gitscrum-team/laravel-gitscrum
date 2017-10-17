<?php

namespace GitScrum\Observers;

use GitScrum\Models\ProductBacklog;
use GitScrum\Models\Organization;
use GitScrum\Classes\Helper;
use Auth;

class ProductBacklogObserver
{
    public function creating(ProductBacklog $productBacklog)
    {
        if (!isset($productBacklog->user_id)) {
            $productBacklog->user_id = Auth::user()->id;
        }

        $productBacklog->slug = Helper::slug($productBacklog->title);
        if (isset($productBacklog->is_api)) {
            $owner = Organization::find($productBacklog->organization_id);
            $productBacklog::$tmp = app(Auth::user()->provider)->createOrUpdateRepository($owner->username, $productBacklog);
        }
    }

    public function created(ProductBacklog $productBacklog)
    {
        if (isset($productBacklog->is_api)) {
            $template = app(Auth::user()->provider)->tplRepository($productBacklog::$tmp, $productBacklog->slug);
            if (! is_null($template)) {
                $obj = ProductBacklog::slug($template->slug)->first();
                $obj->update(get_object_vars($template));
            }
            $productBacklog::$tmp = null;
        }
    }

    public function updating(ProductBacklog $productBacklog)
    {
        $oldRepos = ProductBacklog::find($productBacklog->id);
        $owner = Organization::find($productBacklog->organization_id);
        $repos = app(Auth::user()->provider)->createOrUpdateRepository($owner->username, $productBacklog, $oldRepos->title);
        // skip update if repos object is null to prevent error
        if (! is_null($repos)) {
            $productBacklog->html_url = $repos->html_url;
            $productBacklog->ssh_url = $repos->ssh_url;
            $productBacklog->clone_url = $repos->clone_url;
            $productBacklog->url = $repos->url;
        }
    }
}
