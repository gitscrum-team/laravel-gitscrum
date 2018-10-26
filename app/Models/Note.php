<?php

namespace GitScrum\Models;

use GitScrum\Presenters\NotePresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class Note extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use GlobalPresenter;
    use NotePresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['noteable_type', 'noteable_id', 'user_id',
        'slug', 'title', 'position', 'closed_at', ];

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

    public function noteable()
    {
        return $this->morphTo('noteable');
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusesable')
            ->orderby('created_at', 'DESC');
    }

    public function closedUser()
    {
        return $this->belongsTo(User::class, 'closed_user_id', 'id');
    }
}
