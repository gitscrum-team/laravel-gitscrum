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
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\StatusScope;
use Carbon\Carbon;

class Status extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use StatusScope;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'statuses';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['statusesable_type', 'statusesable_id', 'config_status_id', 'user_id', 'deleted_at'];

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

    public function setUpdatedAtAttribute($value)
    {
    }

    public function user()
    {
        return $this->belongsTo(\GitScrum\Models\User::class, 'user_id', 'id');
    }

    public function configStatus()
    {
        return $this->belongsTo(\GitScrum\Models\ConfigStatus::class, 'config_status_id', 'id');
    }

    public function available()
    {
        return $this->hasMany(\GitScrum\Models\ConfigStatus::class, 'type', 'statusesable_type')
            ->orderby('position', 'ASC');
    }

    public function statusesable()
    {
        return $this->morphTo();
    }
}
