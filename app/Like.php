<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Like  extends Authenticatable
{
    use Notifiable;

    protected $table = 'like';

    public function post(){
        return$this->belongsTo(Post::class);
    }

    public function userprofile(){
        return $this->hasOne('raplet\Userprofile', 'user_id', 'user_id');
    }


}
