<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\CommitScope;
use GitScrum\Scopes\GlobalScope;

class Commit extends Model
{
    use GlobalScope;
    use CommitScope;
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
    protected $fillable = ['product_backlog_id', 'branch_id', 'user_id', 'issue_id', 'sha', 'url', 'message', 'html_url', 'date', 'tree_sha', 'tree_url', 'deleted_at'];

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
        return $this->belongsTo(\GitScrum\Models\Branch::class, 'branch_id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo(\GitScrum\Models\Issue::class, 'issue_id', 'id');
    }

    public function repository()
    {
        return $this->belongsTo(\GitScrum\Models\ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\GitScrum\Models\User::class, 'user_id', 'id');
    }

    public function pullRequestsHasCommits()
    {
        return $this->belongsToMany(\GitScrum\Models\PullRequestsHasCommit::class, 'pull_requests_has_commits', 'commit_id', 'pull_request_id');
    }

    public function files()
    {
        return $this->hasMany(\GitScrum\Models\CommitFile::class, 'commit_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany(\GitScrum\Models\Comment::class, 'commentable');
    }
}
