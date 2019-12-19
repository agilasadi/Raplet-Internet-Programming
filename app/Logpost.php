<?php

namespace raplet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use raplet\Events\PostLog;


class Logpost extends Model
{
    protected $table = 'logposts';

    protected $guarded = [];
    /*
     * Events
     */
    protected $dispatchesEvents = [
        'created' => PostLog::class,
    ];

    public function post(){
        return $this->hasOne(Post::class);
    }
    public function userprofile(){
        return $this->hasOne(Userprofile::class, 'user_id', 'user_id');
    }
}
