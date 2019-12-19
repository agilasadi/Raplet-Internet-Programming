<?php

namespace raplet;

use raplet\Models\Concerns\Contributes;
use Illuminate\Database\Eloquent\Model;
use raplet\Models\Contribution;

class Comment extends Model
{
    use Contributes;
    /**
     * $content_type will be used for logging actions related to this model instance
     * @var string
     */
    protected $content_type = "2";

    protected $table = 'comments';

//    public $class_table = 'comments';

    public function langs()
    {
        return $this->hasOne(Lang::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function userprofile()
    {
        return $this->belongsTo('raplet\Userprofile', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo('raplet\User');
    }

    public function commentlinks()
    {
        return $this->hasOne('raplet\Commentlinks');
    }

    protected $fillable = [
        'likecount', 'dislikecount', 'sharecount', 'reportcount',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public function contribution()
    {
        return $this->morphOne(Contribution::class, 'contributing');
    }

}
