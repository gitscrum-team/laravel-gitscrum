<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use GitScrum\Presenters\SprintPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\SprintScope;
use Carbon\Carbon;

class Sprint extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use SprintScope;
    use SprintPresenter;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sprints';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_backlog_id', 'slug', 'title', 'description', 'version',
        'is_private', 'date_start', 'date_finish', 'state', 'color', 'position', 'closed_at', ];

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

    public function productBacklog()
    {
        return $this->belongsTo(ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'sprint_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'sprint_id', 'id')
            ->orderby('position', 'ASC');
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

    public function status()
    {
        return $this->hasOne(ConfigStatus::class, 'id', 'config_status_id');
    }
}
