<?php

use Faker\Generator as Faker;

$factory->define(\raplet\Logs::class, function (Faker $faker) {
    return [
        'content_type' => '1',
        'post_id' => \raplet\Post::class,
        'user_id' => '1',
    ];
});
