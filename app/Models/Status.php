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

class Status extends Model
{
    use SoftDeletes;
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

    protected static function boot()
    {
        parent::boot();
    }

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

    public function getDateforhumansAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->diffForHumans();
    }

    public function track($alias, $model, $id = null)
    {
        if (!isset($model->config_status_id)) {
            if (is_null($id)) {
                $status = ConfigStatus::type($alias)->default();
            } else {
                $status = ConfigStatus::find($id);
            }

            $model->config_status_id = $status->first()->id;
        }

        $this->create([
            'statusesable_type' => $alias,
            'statusesable_id' => $model->id,
            'config_status_id' => $model->config_status_id,
            'user_id' => $model->user_id, ]);
    }

    public function statusesable()
    {
        return $this->morphTo();
    }
}
