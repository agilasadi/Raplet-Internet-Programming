<?php

use Faker\Generator as Faker;
use raplet\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'content' => $faker->text(25),
        'type' => $faker->text(0),
        'user_id' => $faker->text(1),
        'slug' => $faker->unique()->text('50'),
    ];
});
