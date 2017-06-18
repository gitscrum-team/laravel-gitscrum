<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Scopes;

use GitScrum\Models\ConfigStatus;
use Carbon;

trait SprintScope
{
    public function scopeOrder($query)
    {
        $configStatus = ConfigStatus::type('sprints')->orderby('position', 'ASC')->pluck('id')->implode(',');
        return $query->orderByRaw("FIELD(config_status_id, ".$configStatus.")")
            ->orderby('date_start', 'DESC')
            ->orderby('date_finish', 'ASC');
    }

    public function scopeIssueTypes($query)
    {
        $types = $this->issues->map(function ($issue) {
            return $issue->type;
        })->groupBy('slug')->map(function ($type) {
            $obj = $type->first();
            return [
                    'sprint' => $this->slug,
                    'slug' => $obj->slug,
                    'title' => $obj->title,
                    'color' => $obj->color,
                    'total' => $type->count(), ];
        })->sortByDesc('total')->all();

        return collect($types);
    }

    public function scopeIssuesHasUsers($query)
    {
        $users = $this->issues->map(function ($issue) {
            return $issue->users;
        })->reject(function ($value) {
            return $value == null;
        })->flatten(1)->unique('id')->splice(0, 3);

        return collect($users->all());
    }

    public function scopeActivities($query, $limit = 15)
    {
        $activities = $this->issues()
            ->with('statuses')->get()->map(function ($issue) {
                return $issue->statuses;
            })->flatten(1)->map(function ($statuses) {
                return $statuses;
            })->sortByDesc('created_at')->splice($limit);

        return collect($activities->all());
    }

    public function scopeEffort($query)
    {
        $effort = $this->issues->map(function ($issue) {
            return $issue->configEffort;
        });

        return collect($effort);
    }

    public function scopePullrequests($query)
    {
        $prs = $this->branches->map(function ($branch) {
            if ($branch->pullrequests->count()) {
                return $branch->pullrequests;
            }
        })->reject(function ($value) {
            return $value == null;
        });

        return $prs->all();
    }

    public function scopeTotalAdditions($query)
    {
        $additions = $this->branches->map(function ($branch) {
            return $branch->commits;
        })->flatten(1)->map(function ($commit) {
            return $commit->files;
        })->flatten(1)->sum('additions');

        return $additions;
    }

    public function scopeTotalPullRequests($query)
    {
        $prs = $this->branches->map(function ($branch) {
            return $branch->pullrequests()->count();
        });

        return array_sum($prs->all());
    }

    public function scopeWorkingDays($query, $start = null)
    {
        $begin = strtotime(is_null($start) ? $this->attributes['date_start'] : $start);
        $end = strtotime($this->attributes['date_finish']);
        if ($begin > $end) {
            return 0;
        } else {
            $no_days = 0;
            $weekends = 0;
            while ($begin <= $end) {
                ++$no_days;
                $what_day = date('N', $begin);
                if ($what_day > 5) {
                    ++$weekends;
                }
                $begin += 86400;
            }
            $working_days = $no_days - $weekends;

            return $working_days;
        }
    }

    public function scopeWeeks($query, $start = null)
    {
        $begin = Carbon::parse(is_null($start) ? $this->attributes['date_start'] : $start);
        $end = Carbon::parse($this->attributes['date_finish']);

        return round($begin->diffInDays($end) / 7);
    }
}
