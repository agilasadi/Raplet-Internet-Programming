<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keeper extends Model
{

    protected $table='keepers';

    public function lang(){
        return $this->hasOne('raplet\Lang', 'short_name', 'lang_short');
    }

    public function Keepertrans(){
        return $this->hasMany('raplet\Keepertrans');
    }
    public function transspecific($lid){ //returns the specific translation for the keeper
        return $this->Keepertrans()->where('lang_id', $lid)->first();
    }
}
