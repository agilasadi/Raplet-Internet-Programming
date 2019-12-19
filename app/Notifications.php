<?php

namespace raplet;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo('raplet\User');
    }
    public function userprofile(){
        return $this->belongsTo('raplet\Userprofile', 'user_id', 'user_id');
    }

    public function comment(){
        return $this->belongsTo('raplet\Comment', 'content_id', 'id');
    }
    public function post(){
        return $this->belongsTo('raplet\Post', 'content_id', 'id');
    }


}
