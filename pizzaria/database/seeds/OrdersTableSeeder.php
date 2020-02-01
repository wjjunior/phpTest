<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Order::class, 20)->create();
        $faker = Factory::create();
        $pizzas = App\Pizza::all();
        App\Order::all()->each(function ($order) use ($pizzas, $faker) {
            $ids = $pizzas->random(rand(1, 3))->pluck('id')->toArray();
            foreach ($ids as $id) {
                $order->pizzas()->attach(
                    $id,
                    ['size' => $faker->randomElement(['small', 'medium', 'large']), 'qty' => $faker->numberBetween(1, 10)],
                );
            }
        });
    }
}
