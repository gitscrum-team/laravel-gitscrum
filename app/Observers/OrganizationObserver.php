<?php
/**
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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
