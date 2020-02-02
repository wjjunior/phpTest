<?php

use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Carbon\Carbon;

class OrderControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_return_a_collection_of_orders()
    {
        $faker = Factory::create();
        factory(App\Client::class, 20)->create();
        factory(App\Pizza::class, 20)->create();
        factory(App\Order::class, 5)->create();

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

        $this->json('GET', '/orders');

        $this->assertResponseStatus(200);
        $this->seeJsonStructure([
            '*' => ['id', 'client', 'status', 'arrival', 'total', 'pizzas', 'note']
        ]);
    }

    /**
     * @test
     */
    public function can_create_a_order()
    {

        $faker = Factory::create();
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $response = $this->json('POST', '/orders', [
            'client_id' => $client->id,
            'delivery_time' => $delivery_time = $faker->numberBetween(10, 50),
            'delivery_price' => $delivery_price = $faker->randomFloat(2, 0, 20),
            'pedido' => [[
                "pizza_id" => $pizza->id,
                "size" => $size = $faker->randomElement(['small', 'medium', 'large']),
                "qty" => $qty = $faker->numberBetween(1, 10)
            ]],
            'note' => $note = $faker->realText(50)
        ]);

        $response->seeJsonStructure(
            ['id', 'client', 'status', 'arrival', 'total', 'pizzas', 'note']
        )
            ->seeJsonContains([
                'client' => $client->name,
                'status' => 0,
                'total' => round(($pizza->$size * $qty) + $delivery_price, 2),
                'arrival' => Carbon::now()->addMinutes($delivery_time)->format('H:i'),
                'pizzas' => [[
                    "id" => $pizza->id,
                    "pizza" => $pizza->name,
                    "price" => $pizza->$size,
                    "size" => $size,
                    "qty" => $qty
                ]],
                'note' => $note
            ])->assertResponseStatus(201);

        $this->seeInDatabase('orders', [
            'client_id' => $client->id,
            'delivery_time' => $delivery_time,
            'delivery_price' => $delivery_price,
            'note' => $note
        ]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_order_is_not_found()
    {
        $this->json('GET', 'orders/-1');

        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_return_an_order()
    {
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $order = $this->create('Order', ['client_id' => $client->id]);
        $order->pizzas()->attach(
            $pizza->id,
            ['size' => 'small', 'qty' => 1],
        );

        $this->json('GET', "orders/$order->id");
        $this->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status,
            'total' => $order->total,
            'arrival' => $order->arrival_time,
            'pizzas' => [[
                "id" => $pizza->id,
                "pizza" => $pizza->name,
                "price" => $pizza->small,
                "size" => 'small',
                "qty" => 1
            ]],
            'note' => $order->note
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_pizza_we_want_to_update_is_not_found()
    {
        $this->json('PUT', 'orders/-1');

        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_update_an_order()
    {
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $order = $this->create('Order', ['client_id' => $client->id]);
        $order->pizzas()->attach(
            $pizza->id,
            ['size' => 'small', 'qty' => 1],
        );
        $response = $this->json('PUT', "orders/$order->id", [
            'status' => $order->status + 1,
            'delivery_time' => $order->delivery_time + 10,
            'delivery_price' => $order->delivery_price + 10,
            'note' => $order->note . '_updated',
        ]);

        $response->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status + 1,
            'total' => $order->total + 10,
            'arrival' => Carbon::now()->addMinutes($order->delivery_time + 10)->format('H:i'),
            'pizzas' => [[
                "id" => $pizza->id,
                "pizza" => $pizza->name,
                "price" => $pizza->small,
                "size" => 'small',
                "qty" => 1
            ]],
            'note' => $order->note . '_updated'
        ])->assertResponseStatus(200);

        $this->seeInDatabase('orders', [
            'client_id' => $client->id,
            'delivery_time' => $order->delivery_time + 10,
            'delivery_price' => $order->delivery_price + 10,
            'note' => $order->note . '_updated'
        ]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_order_we_want_to_delete_is_not_found()
    {
        $response = $this->json('DELETE', 'orders/-1');

        $response->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_delete_an_order()
    {
        $client = $this->create('Client');
        $order = $this->create('Order', ['client_id' => $client->id]);
        $this->json('DELETE', "orders/$order->id");
        $this->assertResponseStatus(204);
        $this->notSeeInDatabase('orders', ['id' => $order->id]);
    }

    /**
     * @test
     */
    public function can_add_new_pizzas_to_order()
    {
        $faker = Factory::create();
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $pizza2 = $this->create('Pizza');
        $size = $faker->randomElement(['small', 'medium', 'large']);
        $qty = $faker->numberBetween(1, 10);
        $order = $this->create('Order', ['client_id' => $client->id]);
        $response = $this->json('PUT', "orders/pizza/add/$order->id", [
            'pedido' => [
                [
                    "pizza_id" => $pizza->id,
                    "size" => $size,
                    "qty" => $qty
                ],
                [
                    "pizza_id" => $pizza2->id,
                    "size" => $size,
                    "qty" => $qty
                ]
            ]
        ]);

        $total = round(($pizza->$size * $qty) + ($pizza2->$size * $qty) + $order->delivery_price, 2);
        $response->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status,
            'total' => $total,
            'arrival' => Carbon::now()->addMinutes($order->delivery_time)->format('H:i'),
            'pizzas' => [[
                "id" => $pizza->id,
                "pizza" => $pizza->name,
                "price" => $pizza->$size,
                "size" => $size,
                "qty" => $qty
            ], [
                "id" => $pizza2->id,
                "pizza" => $pizza2->name,
                "price" => $pizza2->$size,
                "size" => $size,
                "qty" => $qty
            ]],
            'note' => $order->note
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function can_add_same_pizzas_to_order()
    {
        $faker = Factory::create();
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $pizza2 = $this->create('Pizza');
        $size = $faker->randomElement(['small', 'medium', 'large']);
        $qty = $faker->numberBetween(1, 10);
        $addQty = $faker->numberBetween(1, 5);
        $order = $this->create('Order', ['client_id' => $client->id]);
        $order->pizzas()->attach([
            $pizza->id => ['size' => $size, 'qty' => $qty],
            $pizza2->id => ['size' => $size, 'qty' => $qty],
        ]);

        $response = $this->json('PUT', "orders/pizza/add/$order->id", [
            'pedido' => [
                [
                    "pizza_id" => $pizza->id,
                    "size" => $size,
                    "qty" => $addQty
                ]
            ]
        ]);

        $total = round(($pizza->$size * ($qty + $addQty)) + ($pizza2->$size * $qty) + $order->delivery_price, 2);
        $response->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status,
            'total' => $total,
            'arrival' => Carbon::now()->addMinutes($order->delivery_time)->format('H:i'),
            'pizzas' => [[
                "id" => $pizza->id,
                "pizza" => $pizza->name,
                "price" => $pizza->$size,
                "size" => $size,
                "qty" => $qty + $addQty
            ], [
                "id" => $pizza2->id,
                "pizza" => $pizza2->name,
                "price" => $pizza2->$size,
                "size" => $size,
                "qty" => $qty
            ]],
            'note' => $order->note
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function can_add_same_and_a_new_pizza_to_order()
    {
        $faker = Factory::create();
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $pizza2 = $this->create('Pizza');
        $pizza3 = $this->create('Pizza');
        $size = $faker->randomElement(['small', 'medium', 'large']);
        $qty = $faker->numberBetween(1, 10);
        $addQty = $faker->numberBetween(1, 5);
        $order = $this->create('Order', ['client_id' => $client->id]);
        $order->pizzas()->attach([
            $pizza->id => ['size' => $size, 'qty' => $qty],
            $pizza2->id => ['size' => $size, 'qty' => $qty],
        ]);

        $response = $this->json('PUT', "orders/pizza/add/$order->id", [
            'pedido' => [
                [
                    "pizza_id" => $pizza->id,
                    "size" => $size,
                    "qty" => $addQty
                ],
                [
                    "pizza_id" => $pizza3->id,
                    "size" => $size,
                    "qty" => $qty
                ]
            ]
        ]);

        $total = round(($pizza->$size * ($qty + $addQty)) + ($pizza2->$size * $qty) + $order->delivery_price, 2);
        $response->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status,
            'total' => $total,
            'arrival' => Carbon::now()->addMinutes($order->delivery_time)->format('H:i'),
            'pizzas' => [
                [
                    "id" => $pizza->id,
                    "pizza" => $pizza->name,
                    "price" => $pizza->$size,
                    "size" => $size,
                    "qty" => $qty + $addQty
                ], [
                    "id" => $pizza2->id,
                    "pizza" => $pizza2->name,
                    "price" => $pizza2->$size,
                    "size" => $size,
                    "qty" => $qty
                ], [
                    "id" => $pizza3->id,
                    "pizza" => $pizza3->name,
                    "price" => $pizza3->$size,
                    "size" => $size,
                    "qty" => $qty
                ]
            ],
            'note' => $order->note
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function can_remove_pizza_from_order()
    {
        $faker = Factory::create();
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $size = $faker->randomElement(['small', 'medium', 'large']);
        $qty = $faker->numberBetween(6, 10);
        $removeQty = $faker->numberBetween(1, 5);
        $order = $this->create('Order', ['client_id' => $client->id]);
        $order->pizzas()->attach([
            $pizza->id => ['size' => $size, 'qty' => $qty],
        ]);

        $response = $this->json('PUT', "orders/pizza/remove/$order->id", [
            "pizza_id" => $pizza->id,
            "size" => $size,
            "qty" => $removeQty
        ]);

        $total = round(($pizza->$size * ($qty - $removeQty)) + $order->delivery_price, 2);
        $response->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status,
            'total' => $total,
            'arrival' => Carbon::now()->addMinutes($order->delivery_time)->format('H:i'),
            'pizzas' => [[
                "id" => $pizza->id,
                "pizza" => $pizza->name,
                "price" => $pizza->$size,
                "size" => $size,
                "qty" => $qty - $removeQty
            ]],
            'note' => $order->note
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function can_remove_all_pizza_qty_from_order()
    {
        $faker = Factory::create();
        $client = $this->create('Client');
        $pizza = $this->create('Pizza');
        $size = $faker->randomElement(['small', 'medium', 'large']);
        $qty = $faker->numberBetween(6, 10);
        $order = $this->create('Order', ['client_id' => $client->id]);
        $order->pizzas()->attach([
            $pizza->id => ['size' => $size, 'qty' => $qty],
        ]);

        $response = $this->json('PUT', "orders/pizza/remove/$order->id", [
            "pizza_id" => $pizza->id,
            "size" => $size,
            "qty" => $qty
        ]);

        $total = round(($pizza->$size * ($qty - $qty)) + $order->delivery_price, 2);
        $response->seeJsonEquals([
            'id' => $order->id,
            'client' => $client->name,
            'status' => $order->status,
            'total' => $total,
            'arrival' => Carbon::now()->addMinutes($order->delivery_time)->format('H:i'),
            'pizzas' => [],
            'note' => $order->note
        ])->assertResponseStatus(200);
    }
}
