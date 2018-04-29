<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'name' => $faker->title(),
        'content' => $faker->text(),
    ];
});