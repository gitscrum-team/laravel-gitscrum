<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class Favorite extends Model
{
    use GlobalScope;
    use GlobalPresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['favoriteable_type', 'favoriteable_id', 'user_id'];

    public function favoriteable()
    {
        return $this->morphTo('favoriteable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
