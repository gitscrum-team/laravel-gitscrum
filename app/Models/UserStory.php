<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GitScrum\Scopes\GlobalScope;
use GitScrum\Scopes\UserStoryScope;

class UserStory extends Model
{
    use SoftDeletes;
    use GlobalScope;
    use GlobalPresenter;
    use UserStoryScope;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_stories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_backlog_id', 'title', 'description', 'config_priority_id', 'acceptance_criteria'];

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

    public function productBacklog()
    {
        return $this->belongsTo(ProductBacklog::class, 'product_backlog_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'user_story_id', 'id')
            ->orderby('position', 'ASC');
    }

    public function priority()
    {
        return $this->hasOne(ConfigPriority::class, 'id', 'config_priority_id');
    }

    public function favorite()
    {
        return $this->morphOne(Favorite::class, 'favoriteable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderby('created_at', 'DESC');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable')
            ->orderby('position', 'ASC');
    }

    public function labels()
    {
        return $this->morphToMany(Label::class, 'labelable');
    }
}
