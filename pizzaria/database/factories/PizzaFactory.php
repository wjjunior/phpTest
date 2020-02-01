<?php

$factory->define(App\Pizza::class, function (Faker\Generator $faker) {
    $price = round($faker->randomFloat(2, 10, 100), 2);
    return [
        'name' => $faker->words(3, true),
        'description' => $faker->realText(200),
        'small' => round($price, 2),
        'medium' => round($price + 10, 2),
        'large' => round($price + 20, 2)
    ];
});
