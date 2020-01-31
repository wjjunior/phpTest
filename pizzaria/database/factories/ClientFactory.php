<?php

$factory->define(App\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'phone_number' => $faker->unique()->phoneNumber,
        'address' => $faker->address,
    ];
});
