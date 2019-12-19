<?php

namespace raplet;

use Illuminate\Database\Eloquent\Model;

class Keepertrans extends Model
{
    protected $table = 'keeper_translate';

    public function keeper(){
        return $this->hasOne('raplet\Keeper');
    }
}
