<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
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

    protected static function boot()
    {
        parent::boot();
    }

    public function labelable()
    {
        return $this->morphTo();
    }

    public function issues()
    {
        return $this->morphedByMany(\GitScrum\Models\Issue::class, 'labelable');
    }

    public function userStories()
    {
        return $this->morphedByMany(\GitScrum\Models\UserStory::class, 'labelable');
    }
}
