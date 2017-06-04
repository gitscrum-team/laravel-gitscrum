<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

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
