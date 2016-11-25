<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;

class PullRequest extends Model
{
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
    protected $fillable = ['github_id', 'head_branch_id', 'base_branch_id', 'user_id', 'product_backlog_id', 'number', 'url', 'html_url', 'issue_url', 'commits_url', 'state', 'title', 'body', 'github_created_at', 'github_updated_at', 'deleted_at'];

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
        return $this->belongsTo(\GitScrum\Models\Branch::class, 'base_branch_id', 'id');
    }

    public function headBranch()
    {
        return $this->belongsTo(\GitScrum\Models\Branch::class, 'head_branch_id', 'id');
    }

    public function repository()
    {
        return $this->belongsTo(\GitScrum\Models\ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(\GitScrum\Models\User::class, 'id', 'user_id');
    }
}
