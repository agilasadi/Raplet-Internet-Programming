<?php

namespace raplet;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Postbadges extends Model
{
    use Notifiable;

    protected $table = 'badge_post';



}
