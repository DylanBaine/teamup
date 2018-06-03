<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 4),
        'type_id' => rand(1, 2),
        'name' => ucwords($faker->sentence()),
        'content' => $faker->paragraph(),
    ];
});
