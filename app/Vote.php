<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Vote  extends Model
{
    use Notifiable;

    protected $table = 'vote';

    public function comment(){
        return$this->belongsTo(Comment::class);
    }


    public function userprofile(){
        return $this->hasOne('raplet\Userprofile', 'user_id', 'user_id');
    }


}
