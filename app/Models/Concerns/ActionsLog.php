<?php

namespace raplet\Models\Concerns;

use Illuminate\Support\Facades\Auth;
use raplet\Logs;

trait ActionsLog
{
    public static function bootActionsLog()
    {
        static::created(
            function($model)
            {
                Logs::create([
                    'user_id' => Auth::id(),
                    'content_id' => $model->id,
                    'content_type' => $model->table,
                    'log_type' => 5
                ]);
            }
        );

        static::deleted(
            function($model)
            {
                Logs::create([
                    'user_id' => Auth::id(),
                    'content_id' => $model->id,
                    'content_type' => $model->table,
                    'log_type' => 4
                ]);
            }
        );


        static::updated(
            function($model)
            {
                Logs::create([
                    'user_id' => Auth::id(),
                    'content_id' => $model->id,
                    'content_type' => $model->table,
                    'log_type' => $model->is_featured
                ]);
            }
        );
    }
}
