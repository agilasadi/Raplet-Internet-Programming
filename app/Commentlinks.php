<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Commentlinks  extends Authenticatable
{
    use Notifiable;

    protected $table = 'commentlinks';

    public function comment(){
        return$this->belongsTo(Comment::class);
    }





}
