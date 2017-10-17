<?php

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class PullRequest extends Model
{
    use GlobalScope;
    use GlobalPresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pull_requests';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provider_id', 'head_branch_id', 'base_branch_id', 'user_id', 'product_backlog_id', 'number',
        'url', 'html_url', 'issue_url', 'commits_url', 'state', 'title', 'body', 'github_created_at', 'github_updated_at',
        'deleted_at'];

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

    public function commits()
    {
        return $this->belongsToMany(
            \GitScrum\Models\Commit::class,
            'pull_requests_has_commits',
            'pull_request_id',
            'commit_id'
        )->withTimestamps();
    }

    public function baseBranch()
    {
        return $this->belongsTo(Branch::class, 'base_branch_id', 'id');
    }

    public function headBranch()
    {
        return $this->belongsTo(Branch::class, 'head_branch_id', 'id');
    }

    public function repository()
    {
        return $this->belongsTo(ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
