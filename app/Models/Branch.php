<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
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
        return $this->belongsTo(\GitScrum\Models\ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function sprint()
    {
        return $this->belongsTo(\GitScrum\Models\Sprint::class, 'sprint_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\GitScrum\Models\User::class, 'user_id', 'id');
    }

    public function commits()
    {
        return $this->hasMany(\GitScrum\Models\Commit::class, 'branch_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(\GitScrum\Models\Issue::class, 'branch_id', 'id');
    }

    public function basePullRequests()
    {
        return $this->hasMany(\GitScrum\Models\PullRequest::class, 'base_branch_id', 'id');
    }

    public function headPullRequests()
    {
        return $this->hasMany(\GitScrum\Models\PullRequest::class, 'head_branch_id', 'id');
    }
}
