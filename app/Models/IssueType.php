<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'issue_types';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'alias', 'title', 'position', 'enabled'];

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

    public function issues()
    {
        return $this->hasMany(\GitScrum\Models\Issue::class, 'issue_type_id', 'id');
    }
}
