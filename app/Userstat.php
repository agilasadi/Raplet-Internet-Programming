<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Userstat extends Model
{
    use Notifiable;

    protected $table = 'userstats';

	protected $fillable = ['user_id'];

    public function userprofile(){
        return $this->belongsTo('raplet\Userprofile', 'user_id', 'user_id');
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }





}
