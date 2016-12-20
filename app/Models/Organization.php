<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organizations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['provider_id', 'username', 'url', 'repos_url', 'events_url', 'hooks_url',
        'issues_url', 'members_url', 'public_members_url', 'avatar_url', 'title', 'description',
        'blog', 'location', 'email', 'public_repos', 'html_url', 'total_private_repos', 'since',
        'disk_usage', 'deleted_at', ];

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

    public function users()
    {
        return $this->belongsToMany(\GitScrum\Models\User::class, 'users_has_organizations')
            ->withTimestamps();
    }

    public function productBacklog()
    {
        return $this->hasMany(\GitScrum\Models\ProductBacklog::class, 'organization_id', 'id');
    }
}
