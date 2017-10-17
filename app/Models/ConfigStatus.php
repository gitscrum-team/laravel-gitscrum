<?php

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use GitScrum\Scopes\ConfigStatusScope;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Presenters\GlobalPresenter;

class ConfigStatus extends Model
{
    use ConfigStatusScope;
    use GlobalScope;
    use GlobalPresenter;

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
