<?php
/**
 * GitScrum v0.1
 *
 * @package  GitScrum
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Classes\Helper;
use Auth;

class UserStory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_stories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_backlog_id', 'title', 'description', 'config_priority_id', 'acceptance_criteria'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected static function boot()
    {
        parent::boot();
    }

    public function productBacklog()
    {
        return $this->belongsTo(\GitScrum\Models\ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(\GitScrum\Models\Issue::class, 'user_story_id', 'id')
            ->orderby('position', 'ASC');
    }

    public function priority()
    {
        return $this->hasOne(\GitScrum\Models\ConfigPriority::class, 'id', 'config_priority_id');
    }

    public function favorite()
    {
        return $this->morphOne(\GitScrum\Models\Favorite::class, 'favoriteable');
    }

    public function comments()
    {
        return $this->morphMany(\GitScrum\Models\Comment::class, 'commentable')
            ->orderby('created_at', 'DESC');
    }

    public function notes()
    {
        return $this->morphMany(\GitScrum\Models\Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }

    public function labels()
    {
        return $this->morphToMany(\GitScrum\Models\Label::class, 'labelable');
    }

    public function getPercentComplete()
    {
        $total = $this->issues->count();
        $totalClosed = $total-$this->issues->where('closed_at', NULL)->count();

        return ($totalClosed) ? ceil(($totalClosed * 100) / $total) : 0;
    }

    public function activities()
    {
        $activities = $this->issues()
            ->with('statuses')->get()->map(function($issue){
                return $issue->statuses;
        })->flatten(1)->map(function($statuses){
            return $statuses;
        })->sortByDesc('created_at');

        $activities->splice(15);

        return $activities->all();
    }

    public function issuesHasUsers($total = 3)
    {
        $users = $this->issues->map(function ($issue) {
                return $issue->users;
        })->reject(function ($value) {
            return $value == null;
        })->flatten(1)->unique('id')->splice(0, $total);

        return $users->all();
    }

    public function issueStatus()
    {
        $status = $this->issues->map(function($issue){
            return $issue->status;
        })->groupBy('slug')->all();

        return $status;
    }

    public function notesPercentComplete()
    {
        $total = $this->notes->count();
        $totalClosed = $total-$this->notes->where('closed_at', NULL)->count();

        return ($totalClosed) ? ceil(($totalClosed * 100) / $total) : 0;
    }

}
