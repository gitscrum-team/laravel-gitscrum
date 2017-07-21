<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class Comment extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use GlobalPresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['commentable_type', 'commentable_id', 'user_id', 'comment'];

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

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'commentable_id', 'id');
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusesable')
            ->orderby('created_at', 'DESC');
    }
}
