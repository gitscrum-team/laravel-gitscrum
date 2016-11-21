<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Commit extends Model
{
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

    public function totalLines()
    {
        $lines = $this->files->map(function ($file) {
            return count(preg_split('/\R/', $file->raw));
        });

        return array_sum($lines->all());
    }

    public function totalAdditions()
    {
        $additions = $this->files->map(function ($file) {
            return $file->additions;
        });

        return array_sum($additions->all());
    }

    public function totalChanges()
    {
        $changes = $this->files->map(function ($file) {
            return $file->changes;
        });

        return array_sum($changes->all());
    }

    public function totalDeletions()
    {
        $deletions = $this->files->map(function ($file) {
            return $file->deletions;
        });

        return array_sum($deletions->all());
    }

    public function totalPHPCS($type = 'ERROR')
    {
        $errors = $this->files->map(function ($file) use ($type) {
            return $file->filePhpcs()->where('type', '=', $type)->groupBy('type')->count();
        });

        return array_sum($errors->all());
    }

    public function getDateforhumansAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->diffForHumans();
    }

    public function comments()
    {
        return $this->morphMany(\GitScrum\Models\Comment::class, 'commentable');
    }
}
