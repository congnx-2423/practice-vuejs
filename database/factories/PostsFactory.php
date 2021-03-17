<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;


$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 10),
        'content' => $faker->name,
    ];
});
