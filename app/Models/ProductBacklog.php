<?php

namespace GitScrum\Models;

use GitScrum\Presenters\ProductBacklogPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class ProductBacklog extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use GlobalPresenter;
    use ProductBacklogPresenter;

    public static $tmp = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_backlogs';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provider_id', 'user_id', 'organization_id', 'slug', 'title', 'description',
        'fullname', 'private', 'html_url', 'description', 'fork', 'url', 'since', 'pushed_at',
        'git_url', 'ssh_url', 'clone_url', 'homepage', 'default_branch', 'is_api', ];

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
    protected $casts = ['private' => 'boolean', 'fork' => 'boolean'];

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class, 'product_backlog_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'product_backlog_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'product_backlog_id', 'id')
            ->orderby('position', 'ASC');
    }

    public function userStories()
    {
        return $this->hasMany(UserStory::class, 'product_backlog_id', 'id');
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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderby('created_at', 'DESC');
    }
}
