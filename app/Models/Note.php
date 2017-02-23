<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\{Model,SoftDeletes};
use GitScrum\Scopes\GlobalScope;

class Note extends Model
{
    use SoftDeletes;
    use GlobalScope;

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

    public function setClosedUserIdAttribute($value)
    {
        $this->attributes['closed_user_id'] = is_null($this->closed_at) ? $value : null;
    }

    public function setClosedAtAttribute($value)
    {
        $this->attributes['closed_at'] = is_null($this->closed_at) ? $value : null;
    }
}
