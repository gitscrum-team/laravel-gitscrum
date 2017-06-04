<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use GitScrum\Presenters\UserPresenter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\UserScope;

class User extends Authenticatable
{
    use GlobalScope;
    use UserScope;
    use UserPresenter;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provider_id', 'provider', 'username', 'name', 'avatar', 'html_url', 'email',
        'bio', 'location', 'blog', 'since', 'token', 'main_repository', 'position_held', ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function configStatuses()
    {
        return $this->belongsToMany(ConfigStatus::class, 'statuses', 'user_id', 'id');
    }

    public function issues()
    {
        return $this->belongsToMany(Issue::class, 'issues_has_users', 'user_id', 'issue_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'users_has_organizations')
            ->withTimestamps();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'user_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function commits()
    {
        return $this->hasMany(Commit::class, 'user_id', 'id');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class, 'user_id', 'id');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }
}
