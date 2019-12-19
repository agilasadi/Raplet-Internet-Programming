<?php

namespace raplet;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $fillable = 'log_type';

    public function comments(){
        return $this->hasOne('raplet\Comment', 'id', 'content_id');
    }
    public function posts(){
        return $this->hasOne('raplet\Post', 'id', 'content_id');
    }


}
