<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Userbadges extends Model
{
    use Notifiable;

    protected $table = 'badge_user';

    public function badges(){
        return $this->hasOne('raplet\Badge', 'id', 'badge_id');
    }

}
