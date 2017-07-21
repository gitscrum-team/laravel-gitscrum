<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\CommitScope;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class Commit extends Model
{
    use GlobalScope;
    use CommitScope;
    use GlobalPresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'commits';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_backlog_id', 'branch_id', 'user_id', 'issue_id',
        'sha', 'url', 'message', 'html_url', 'date', 'tree_sha', 'tree_url', 'deleted_at'];

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

    protected $morphClass = 'commit';

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id', 'id');
    }

    public function repository()
    {
        return $this->belongsTo(ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pullRequestsHasCommits()
    {
        return $this->belongsToMany(PullRequestsHasCommit::class, 'pull_requests_has_commits', 'commit_id', 'pull_request_id');
    }

    public function files()
    {
        return $this->hasMany(CommitFile::class, 'commit_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
