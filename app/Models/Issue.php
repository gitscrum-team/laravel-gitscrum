<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use GitScrum\Presenters\IssuePresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\IssueScope;

class Issue extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use IssueScope;
    use IssuePresenter;
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
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(IssueType::class, 'issue_type_id', 'id');
    }

    public function configEffort()
    {
        return $this->belongsTo(ConfigIssueEffort::class, 'config_issue_effort_id', 'id');
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'sprint_id', 'id');
    }

    public function productBacklog()
    {
        return $this->belongsTo(ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function userStory()
    {
        return $this->belongsTo(UserStory::class, 'user_story_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function closedUser()
    {
        return $this->belongsTo(User::class, 'closed_user_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'issues_has_users', 'issue_id', 'user_id');
    }

    public function commits()
    {
        return $this->hasMany(Commit::class, 'issue_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderby('created_at', 'DESC');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }

    public function favorite()
    {
        return $this->morphOne(Favorite::class, 'favoriteable');
    }

    public function labels()
    {
        return $this->morphToMany(Label::class, 'labelable');
    }

    public function status()
    {
        return $this->hasOne(ConfigStatus::class, 'id', 'config_status_id');
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusesable')
            ->orderby('created_at', 'DESC');
    }
}
