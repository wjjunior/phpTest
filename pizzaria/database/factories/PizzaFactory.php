<?php

$factory->define(App\Pizza::class, function (Faker\Generator $faker) {
    $price = $faker->randomFloat(2, 10, 100);
    return [
        'name' => $faker->words(3, true),
        'description' => $faker->realText(200),
        'small' => $price,
        'medium' => $price + 10,
        'large' => $price + 20
    ];
});
