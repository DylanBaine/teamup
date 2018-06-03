<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 4),
        'type_id' => rand(5, 6),
        'name' => ucwords($faker->sentence(1)),
        'content' => $faker->paragraph(5),
    ];
});
