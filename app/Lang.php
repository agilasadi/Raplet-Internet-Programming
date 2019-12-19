<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{

    protected $table='langs';



    public function userprofiles(){
        return $this->belongsTo('raplet\Userprofile');
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
