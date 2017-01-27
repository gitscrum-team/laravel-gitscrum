<?php

namespace GitScrum\Scopes;

use GitScrum\Models\Sprint;

trait UserScope
{

    public function scopeLabels($feature)
    {
        return $this->{$feature}->map(function ($obj) {
            return $obj->labels;
        })->flatten(1)->unique('id');
    }

    public function scopeProductBacklogs($query, $product_backlog_id = null)
    {
        return $this->organizations()
            ->with('productBacklog.sprints')
            ->with('productBacklog.userStories')
            ->with('productBacklog.favorite')
            ->with('productBacklog.organization')
            ->with('productBacklog.issues')->get()
            ->map(function ($organization) use ($product_backlog_id) {
                $obj = $organization->productBacklog()
                    ->get();

                if (!is_null($product_backlog_id)) {
                    $obj = $obj->where('id', $product_backlog_id);
                }

                return $obj;
        })->flatten(1);
    }

    public function scopeSprints($query, $sprint_id = null)
    {
        return Sprint::whereIn('product_backlog_id', [$this->productBacklogs()->pluck('id')->implode(',')]);
    }

    public function scopeUserStories($query, $user_story_id = null)
    {
        return $this->productBacklogs()->map(function ($productBacklog) use ($user_story_id) {
            $obj = $productBacklog->userStories()->get();

            if (!is_null($user_story_id)) {
                $obj = $obj->where('id', $user_story_id);
            }

            return $obj;
        })->flatten(1);
    }

    public function scopeTeam($query)
    {
        return $this->organizations->map(function ($obj) {
            return $obj->users;
        })->flatten(1)->unique('id');
    }

    public function scopeActivities($query, $user_id = null, $limit = 6)
    {
        return $this->team()->map(function ($obj) use ($user_id) {
            $statuses = $obj->statuses;
            if (!is_null($user_id)) {
                $statuses = $statuses->where('user_id', $user_id);
            }

            return $statuses;
        })->flatten(1)->sortByDesc('id')->take($limit);
    }
}
