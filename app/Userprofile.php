<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{

    protected $table='userprofiles';

    protected $fillable = ['user_id', 'userImg', 'slug', 'name', 'bio', 'password'];

    public function user(){
        return $this->belongsTo('raplet\User');
    }
    public function userstat(){
        return $this->hasOne('raplet\Userstat', 'user_id', 'user_id');
    }

    public function lang()
    {
        return $this->hasOne('raplet\Lang');
    }

    public function post(){
        return $this->hasMany('raplet\Post', 'user_id', 'user_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function logs(){
        return $this->hasMany('raplet\Logs', 'user_id', 'user_id');
    }

    public function role(){
        return $this->hasOne('raplet\Rank', 'id', 'role_id');
    }


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

}
