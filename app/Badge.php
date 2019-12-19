<?php

namespace raplet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class Badge extends Model
{
    protected $table = 'badges';

    public function posts(){
        return $this->belongsToMany('raplet\Post');
    }

}
