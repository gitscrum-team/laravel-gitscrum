<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Scopes;

trait UserStoryScope
{
    public function scopeActivities($query)
    {
        $activities = $this->issues()
            ->with('statuses')->get()->map(function ($issue) {
                return $issue->statuses;
            })->flatten(1)->map(function ($statuses) {
                return $statuses;
            })->sortByDesc('created_at');

        $activities->splice(15);

        return collect($activities->all());
    }

    public function scopeIssuesHasUsers($query, $total = 3)
    {
        $users = $this->issues->map(function ($issue) {
            return $issue->users;
        })->reject(function ($value) {
            return $value == null;
        })->flatten(1)->unique('id')->splice(0, $total);

        return collect($users->all());
    }
}
