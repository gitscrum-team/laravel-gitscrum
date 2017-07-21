<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class Branch extends Model
{
    use GlobalScope;
    use GlobalPresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'branches';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sprint_id', 'product_backlog_id', 'sha', 'title', 'deleted_at'];

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function ProductBacklog()
    {
        return $this->belongsTo(ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class, 'sprint_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function commits()
    {
        return $this->hasMany(Commit::class, 'branch_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'branch_id', 'id');
    }

    public function basePullRequests()
    {
        return $this->hasMany(PullRequest::class, 'base_branch_id', 'id');
    }

    public function headPullRequests()
    {
        return $this->hasMany(PullRequest::class, 'head_branch_id', 'id');
    }
}
