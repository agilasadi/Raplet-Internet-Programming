<?php

namespace raplet;

use Illuminate\Database\Eloquent\Model;

class Postmedia extends Model
{

    protected $table='postmedia';



    public function posts()
    {
        return $this->hasOne(Post::class);
    }


}
