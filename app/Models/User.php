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
use GitScrum\Classes\Helper;
use Carbon\Carbon;
use Auth;

class User extends Authenticatable
{
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
    protected $fillable = ['github_id', 'username', 'name', 'avatar', 'html_url', 'email',
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
                $obj = $obj->where('id', '=', $product_backlog_id);
            }

            return $obj;
        })->flatten(1);
    }

    public function burdown()
    {
        $helper = new Helper();
        $dt_finish = Carbon::now();

        $date_finish = $dt_finish->toDateString();
        $date_start = $dt_finish->subMonths(1)->toDateString();

        $issues = $this->issues;

        $total = $issues->count();

        $dates = $helper->arrayDateRange([$date_start, $date_finish], $total);

        $previous = $date_start;
        $arr = [];
        $arr[$previous] = $total;

        foreach ($dates as $date => $value) {
            $closed = $issues()->whereDate('closed_at', '=', $date)->count();
            $totalPrevious = $total - $arr[$previous];
            $arr[$date] = $total - ($closed + $totalPrevious);
            $previous = $date;
        }

        return $arr;
    }

    public function team()
    {
        return $this->organizations->map(function ($obj) {
            return $obj->users;
        })->flatten(1)->unique('id');
        //->where('id', '!=', Auth::user()->id);
    }

    public function activities()
    {
        return $this->team()->map(function ($obj) {
            return $obj->statuses;
        })->flatten(1)->sortByDesc('id')->take(6);
    }
}
