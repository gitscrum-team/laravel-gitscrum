<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\IssueScope;
use GitScrum\Classes\Parsedown;

class Issue extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use IssueScope;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'issues';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['config_issue_effort_id', 'issue_type_id', 'provider_id', 'provider', 'user_id', 'product_backlog_id', 'parent_id',
        'branch_id', 'sprint_id', 'user_story_id', 'number', 'effort', 'slug', 'code', 'title', 'description', 'state',
        'config_status_id', 'position', 'is_planning_poker', 'closed_user_id', 'closed_at', ];

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

    protected $dates = ['deleted_at'];

    public function branch()
    {
        return $this->belongsTo(\GitScrum\Models\Branch::class, 'branch_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(\GitScrum\Models\IssueType::class, 'issue_type_id', 'id');
    }

    public function configEffort()
    {
        return $this->belongsTo(\GitScrum\Models\ConfigIssueEffort::class, 'config_issue_effort_id', 'id');
    }

    public function sprint()
    {
        return $this->belongsTo(\GitScrum\Models\Sprint::class, 'sprint_id', 'id');
    }

    public function productBacklog()
    {
        return $this->belongsTo(\GitScrum\Models\ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function userStory()
    {
        return $this->belongsTo(\GitScrum\Models\UserStory::class, 'user_story_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\GitScrum\Models\User::class, 'user_id', 'id');
    }

    public function closedUser()
    {
        return $this->belongsTo(\GitScrum\Models\User::class, 'closed_user_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(\GitScrum\Models\User::class, 'issues_has_users', 'issue_id', 'user_id');
    }

    public function commits()
    {
        return $this->hasMany(\GitScrum\Models\Commit::class, 'issue_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(\GitScrum\Models\Comment::class, 'commentable')
            ->orderby('created_at', 'DESC');
    }

    public function attachments()
    {
        return $this->morphMany(\GitScrum\Models\Attachment::class, 'attachmentable');
    }

    public function notes()
    {
        return $this->morphMany(\GitScrum\Models\Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }

    public function favorite()
    {
        return $this->morphOne(\GitScrum\Models\Favorite::class, 'favoriteable');
    }

    public function labels()
    {
        return $this->morphToMany(\GitScrum\Models\Label::class, 'labelable');
    }

    public function status()
    {
        return $this->hasOne(\GitScrum\Models\ConfigStatus::class, 'id', 'config_status_id');
    }

    public function statuses()
    {
        return $this->morphMany(\GitScrum\Models\Status::class, 'statusesable')
            ->orderby('created_at', 'DESC');
    }

    public function getNumberAttribute()
    {
        return isset($this->attributes['number']) ? $this->attributes['number'] : null;
    }

    public function getStatusAvailableAttribute()
    {
        return \GitScrum\Models\ConfigStatus::type('issues')->get();
    }

    public function getSprintSlugAttribute()
    {
        return isset($this->sprint->slug) ? $this->sprint->slug : 0;
    }

    public function getSprintClosedAttribute()
    {
        return isset($this->sprint->closed_at) ? $this->sprint->closed_at : null;
    }

    public function getDescriptionAttribute()
    {
        $parsedown = new Parsedown;
        return $parsedown->text($this->attributes['description']);
    }

    public function getMarkdownDescriptionAttribute()
    {
        return $this->attributes['description'];
    }
}
