<?php

namespace GitScrum\Observers;

use GitScrum\Models\Organization;
use Auth;

class OrganizationObserver
{
    public function creating(Organization $organization)
    {
        if (!isset($organization->provider)) {
            $organization->provider = strtolower(Auth::user()->provider);
        }
    }
}
