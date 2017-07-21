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

class IssueType extends Model
{
    use GlobalScope;
    use GlobalPresenter;

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
        return $this->hasMany(Issue::class, 'issue_type_id', 'id');
    }
}
