<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'cid' => mt_rand(2, 5),
        'title' => $faker->sentence(),
        'desn' => $faker->sentence(),
        'pic'=>'/uploads/articles/GZA5LfdQqVX1OjWi2xHhjCpgzBgbeJwq6IcfBdmA.jpeg',
        'body' => $faker->text()
    ];
});



