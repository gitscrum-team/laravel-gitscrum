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

class Label extends Model
{
    use GlobalScope;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'slug', 'title', 'position', 'color'];

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
    protected $dates = [];

    public function labelable()
    {
        return $this->morphTo();
    }

    public function issues()
    {
        return $this->morphedByMany(Issue::class, 'labelable');
    }

    public function userStories()
    {
        return $this->morphedByMany(UserStory::class, 'labelable');
    }
}
