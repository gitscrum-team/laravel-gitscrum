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
use Carbon\Carbon;
use GitScrum\Classes\Helper;

class Sprint extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sprints';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_backlog_id', 'slug', 'title', 'description', 'version',
        'is_private', 'date_start', 'date_finish', 'state', 'color', 'position', 'closed_at', ];

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

    protected static function boot()
    {
        parent::boot();
    }

    public function productBacklog()
    {
        return $this->belongsTo(\GitScrum\Models\ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function branches()
    {
        return $this->hasMany(\GitScrum\Models\Branch::class, 'sprint_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(\GitScrum\Models\Issue::class, 'sprint_id', 'id')
            ->orderby('position', 'ASC');
    }

    public function issuesHasUsers()
    {
        $users = $this->issues->map(function ($issue) {
            return $issue->users;
        })->reject(function ($value) {
            return $value == null;
        })->flatten(1)->unique('id')->splice(0, 3);

        return $users->all();
    }

    public function comments()
    {
        return $this->morphMany(\GitScrum\Models\Comment::class, 'commentable')
            ->orderby('created_at', 'DESC');
    }

    public function attachments()
    {
        return $this->morphMany(\GitScrum\Models\Attachment::class, 'attachmentable');
    }

    public function notes()
    {
        return $this->morphMany(\GitScrum\Models\Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }

    public function favorite()
    {
        return $this->morphOne(\GitScrum\Models\Favorite::class, 'favoriteable');
    }

    public function status()
    {
        return $this->hasOne(\GitScrum\Models\ConfigStatus::class, 'id', 'config_status_id');
    }

    public function pullrequests()
    {
        $prs = $this->branches->map(function ($branch) {
            if ($branch->pullrequests->count()) {
                return $branch->pullrequests;
            }
        })->reject(function ($value) {
            return $value == null;
        });

        return $prs->all();
    }

    public function getPercentComplete()
    {
        $total = $this->issues->count();
        $totalClosed = $total - $this->issues->where('closed_at', null)->count();

        return ($totalClosed) ? ceil(($totalClosed * 100) / $total) : 0;
    }

    public function notesPercentComplete()
    {
        $total = $this->notes->count();
        $totalClosed = $total - $this->notes->where('completed_at', null)->count();

        return ($totalClosed) ? ceil(($totalClosed * 100) / $total) : 0;
    }

    public function totalAdditions()
    {
        $additions = $this->branches->map(function ($branch) {
            return $branch->commits;
        })->flatten(1)->map(function ($commit) {
            return $commit->files;
        })->flatten(1)->sum('additions');

        return $additions;
    }

    public function totalPullRequests()
    {
        $prs = $this->branches->map(function ($branch) {
            return $branch->pullrequests()->count();
        });

        return array_sum($prs->all());
    }

    public function workingDays($start = null)
    {
        $begin = strtotime(is_null($start) ? $this->attributes['date_start'] : $start);
        $end = strtotime($this->attributes['date_finish']);
        if ($begin > $end) {
            return 0;
        } else {
            $no_days = 0;
            $weekends = 0;
            while ($begin <= $end) {
                ++$no_days;
                $what_day = date('N', $begin);
                if ($what_day > 5) {
                    ++$weekends;
                }
                $begin += 86400;
            }
            $working_days = $no_days - $weekends;

            return $working_days;
        }
    }

    public function weeks($start = null)
    {
        $begin = Carbon::parse(is_null($start) ? $this->attributes['date_start'] : $start);
        $end = Carbon::parse($this->attributes['date_finish']);

        return round($begin->diffInDays($end) / 7);
    }

    public function getPSR2Errors()
    {
        $errors = 0;
        /*
        foreach ($this->branches as $branch) {
            foreach ($branch->commits as $commit) {
                foreach ($commit->files as $file) {
                    $errors += $file->filePhpcs->count();
                }
            }
        }
        */
        return $errors;
    }

    public function getEffort()
    {
        $effort = $this->issues->sum('effort');

        return $effort;
    }

    public function avgEffort()
    {
        $effort = round($this->issues->avg('effort'), 2);

        return $effort;
    }

    public function burdown()
    {
        $helper = new Helper();
        $total = $this->issues->count();
        $finished = (Carbon::now() > $this->attributes['date_finish']) ? Carbon::now() : $this->attributes['date_finish'];
        $finished = (is_null($this->attributes['closed_at'])) ? $finished : $this->attributes['closed_at'];

        $dates = $helper->arrayDateRange([$this->attributes['date_start'], $finished], $total);

        $previous = $this->attributes['date_start'];
        $arr = [];
        $arr[$previous] = $total;

        foreach ($dates as $date => $value) {
            $closed = $this->issues()->whereDate('closed_at', '=', $date)->count();
            $totalPrevious = $total - $arr[$previous];
            $arr[$date] = $total - ($closed + $totalPrevious);
            $previous = $date;
        }

        return $arr;
    }

    public function activities()
    {
        $activities = $this->issues()
            ->with('statuses')->get()->map(function ($issue) {
                return $issue->statuses;
            })->flatten(1)->map(function ($statuses) {
                return $statuses;
            })->sortByDesc('created_at');

        $activities->splice(15);

        return $activities->all();
    }

    public function issueTypes()
    {
        $types = $this->issues->map(function ($issue) {
            return $issue->type;
        })->groupBy('slug')->map(function ($type) {
            return [
                'sprint' => $this->slug,
                'slug' => $type->first()->slug,
                'title' => $type->first()->title,
                'color' => $type->first()->color,
                'total' => $type->count(), ];
        })->sortByDesc('total')->all();

        return $types;
    }

    public function issueStatus()
    {
        $status = $this->issues->map(function ($issue) {
            return $issue->status;
        })->groupBy('slug')->all();

        return $status;
    }

    public function getVisibilityAttribute()
    {
        return $this->attributes['is_private'] ? _('Private') : _('Public');
    }
}
