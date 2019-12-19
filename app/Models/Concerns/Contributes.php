<?php

namespace raplet\Models\Concerns;

use raplet\Models\Contribution;

trait Contributes
{
    public static function boot()
    {
        self::created(
            function($model)
            {
                Contribution::create([
                    'contributing_id' => $model->id,
                    'contributing_type' => $model->table
                ]);
            }
        );
        self::updated(
            function($model)
            {
                $model->contribution->update(["is_featured" => $model->is_featured]);
            }
        );
    }
}
