<?php

$factory->define(App\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'phone_number' => (string) $faker->unique()->randomNumber(8),
        'address' => $faker->address,
    ];
});
