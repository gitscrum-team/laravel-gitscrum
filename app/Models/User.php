<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GitScrum\Scopes\GlobalScope;

class User extends Authenticatable
{
    use GlobalScope;
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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        if (empty($value)) {
            $this->attributes['name'] = $this->attributes['username'];
        }
    }

    public function configStatuses()
    {
        return $this->belongsToMany(\GitScrum\Models\ConfigStatus::class, 'statuses', 'user_id', 'id');
    }

    public function issues()
    {
        return $this->belongsToMany(\GitScrum\Models\Issue::class, 'issues_has_users', 'user_id', 'issue_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(\GitScrum\Models\Organization::class, 'users_has_organizations')
            ->withTimestamps();
    }

    public function organizationActive()
    {
        return $this->belongsToMany(\GitScrum\Models\Organization::class, 'users_has_organizations', 'user_id', 'organization_id')
            ->withTimestamps();
    }

    public function attachments()
    {
        return $this->hasMany(\GitScrum\Models\Attachment::class, 'user_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany(\GitScrum\Models\Branch::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(\GitScrum\Models\Comment::class, 'user_id', 'id');
    }

    public function commits()
    {
        return $this->hasMany(\GitScrum\Models\Commit::class, 'user_id', 'id');
    }

    public function statuses()
    {
        return $this->hasMany(\GitScrum\Models\Status::class, 'user_id', 'id');
    }

    public function notes()
    {
        return $this->morphMany(\GitScrum\Models\Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }

    public function labels($feature)
    {
        return $this->{$feature}->map(function ($obj) {
            return $obj->labels;
        })->flatten(1)->unique('id');
    }

    public function productBacklogs($product_backlog_id = null)
    {
        return $this->organizations->map(function ($organization) use ($product_backlog_id) {
            $obj = $organization->productBacklog()
                ->with('sprints')
                ->with('favorite')
                ->with('organization')
                ->with('issues')->get();

            if (!is_null($product_backlog_id)) {
                $obj = $obj->find($product_backlog_id);
            }

            return $obj;
        })->flatten(1);
    }

    public function sprints($sprint_id = null)
    {
        $sprints = $this->issues->where('sprint_id', '!=', null)->map(function ($issue) use ($sprint_id) {
            if (!is_null($sprint_id)) {
                $obj = $issue->sprint()->where('id', $sprint_id)->get();
            } else {
                $obj = $issue->sprint()->get();
            }

            return $obj;
        })->flatten(1)->unique('id');

        return $sprints;
    }

    public function team()
    {
        return $this->organizations->map(function ($obj) {
            return $obj->users;
        })->flatten(1)->unique('id');
    }

    public function activities($user_id = null, $limit = 6)
    {
        return $this->team()->map(function ($obj) use ($user_id) {
            $statuses = $obj->statuses;
            if (!is_null($user_id)) {
                $statuses = $statuses->userActive($user_id);
            }

            return $statuses;
        })->flatten(1)->sortByDesc('id')->take($limit);
    }

    public function getProviderAttribute()
    {
        return ucfirst($this->attributes['provider']);
    }
}
