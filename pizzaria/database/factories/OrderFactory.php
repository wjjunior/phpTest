<?php

$factory->define(App\Order::class, function (Faker\Generator $faker) {
    return [
        'status' => 0,
        'client_id' => $faker->numberBetween(1, 20),
        'delivery_time' => $faker->numberBetween(10, 50),
        'delivery_price' => $faker->randomFloat(2, 0, 20),
        'note' => $faker->realText(50)
    ];
});
