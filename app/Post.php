<?php

namespace raplet;

use raplet\Models\Concerns\ActionsLog;
use raplet\Models\Concerns\Contributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Laravel\Scout\Searchable;
use raplet\Models\Contribution;


class Post extends Model
{
    use Contributes, Searchable, ActionsLog;

    protected $table = 'posts';


    /*
    protected $events = [
        'created' => Events\NewPost::class
    ];
    */

    public function comments()
    {
        return $this->hasMany('raplet\Comment');
    }

    public function badges()
    {
        return $this->belongsToMany('raplet\Badge');
    }

    public function userprofile()
    {
        return $this->hasOne('raplet\Userprofile', 'user_id', 'user_id');
    }

    public function logposts()
    {
        return $this->hasOne('raplet\Logpost');
    }

    public function postLastState()
    {
        $possibleLog = [2, 3];
        return $this->hasOne(Logpost::class)->whereIn('log_type', $possibleLog)->orderByDesc('id');
    }

    public function postmedia()
    {
        return $this->hasOne(Postmedia::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function bestComment()
    {
        $is_featured = [0, 4];
        $shortname = Config::get('app.locale');
        $lang = Lang::where('short_name', $shortname)->first()->id;
        return $this->hasOne(Comment::class)->where('lang_id', $lang)->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc');
    }

    public function bestCommentGlobal()
    {
        $is_featured = [0, 4];
        return $this->hasOne(Comment::class)->whereNotIn('is_featured', $is_featured)->orderBy('likecount', 'desc');
    }

    public function contribution()
    {
        return $this->morphOne(Contribution::class, 'contributing');
    }

}
