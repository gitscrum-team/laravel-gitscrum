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
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\SprintScope;

class Sprint extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use SprintScope;
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

    public function getVisibilityAttribute()
    {
        return $this->attributes['is_private'] ? trans('Private') : trans('Public');
    }

    public function getSlugAttribute()
    {
        return isset($this->attributes['slug']) ? $this->attributes['slug'] : '';
    }

    public function getTimeboxAttribute()
    {
        $date_start = isset($this->attributes['date_start']) ?
            Carbon::parse($this->attributes['date_start'])->toDateString() : '';
        $date_finish = isset($this->attributes['date_finish']) ?
            Carbon::parse($this->attributes['date_finish'])->toDateString() : '';

        return $date_start.' '.trans('to').' '.$date_finish;
    }
}
