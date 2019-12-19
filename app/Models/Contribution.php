<?php

namespace raplet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contribution extends Model
{
    use SoftDeletes;

    protected $table = "contribution";

    protected $guarded = [];

    public function contributing()
    {
        return $this->morphTo();
    }
}
