<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\ConfigStatusScope;
use GitScrum\Scopes\GlobalScope;

class ConfigStatus extends Model
{
    use ConfigStatusScope;
    use GlobalScope;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'config_statuses';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'name', 'description', 'position'];

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

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'statuses', 'id', 'user_id');
    }

    public function status()
    {
        //return $this->hasOne(\GitScrum\Models\Status::class, 'id', 'id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'config_status_id', 'id');
    }
}
