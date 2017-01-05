<?php

namespace GitScrum\Scopes;

use GitScrum\Models\ConfigStatus;

trait SprintScope
{
	public function scopeOrder($query)
	{
		$configStatus = ConfigStatus::type('sprint')->orderby('position', 'ASC')->pluck('id')->implode(',');
		return $query->orderByRaw("FIELD(config_status_id, ".$configStatus.")")
			->orderby('date_start', 'DESC')
            ->orderby('date_finish', 'ASC');
	}
}
