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

class CommitFilePhpc extends Model
{
    use GlobalScope;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'commit_file_phpcs';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['commit_file_id', 'line', 'message', 'type'];

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

    public function commitFile()
    {
        return $this->belongsTo(CommitFile::class, 'commit_file_id', 'id');
    }
}
