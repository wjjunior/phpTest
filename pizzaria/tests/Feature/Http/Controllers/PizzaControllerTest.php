<?php

use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PizzaControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_return_a_collection_of_paginated_pizzas()
    {
        for ($i = 0; $i <= 3; $i++) {
            $this->create('Pizza');
        }

        $this->json('GET', '/pizzas');

        $this->assertResponseStatus(200);
        $this->seeJsonStructure([
            '*' => ['id', 'name', 'description', 'small', 'medium', 'large', 'created_at']
        ]);
    }

    /**
     * @test
     */
    public function can_create_a_pizza()
    {

        $faker = Factory::create();
        $price = $faker->randomFloat(2, 10, 100);
        $response = $this->json('POST', '/pizzas', [
            'name' => $name = $faker->words(3, true),
            'description' => $description = $faker->realText(200),
            'small' => $small = $price,
            'medium' => $medium = $price + 10,
            'large' => $large = $price + 20,
        ]);

        $response->seeJsonStructure(
            ['id', 'name', 'description', 'small', 'medium', 'large', 'created_at']
        )
            ->seeJsonContains([
                'name' => $name,
                'description' => $description,
                'small' => $small,
                'medium' => $medium,
                'large' => $large
            ])->assertResponseStatus(201);

        $this->seeInDatabase('pizzas', [
            'name' => $name,
            'description' => $description,
            'small' => $small,
            'medium' => $medium,
            'large' => $large
        ]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_pizza_is_not_found()
    {
        $this->json('GET', 'pizzas/-1');

        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_return_a_pizza()
    {
        $pizza = $this->create('Pizza');
        $this->json('GET', "pizzas/$pizza->id");
        $this->seeJsonEquals([
            'id' => $pizza->id,
            'name' => $pizza->name,
            'description' => $pizza->description,
            'small' => $pizza->small,
            'medium' => $pizza->medium,
            'large' => $pizza->large,
            'created_at' => (string) $pizza->created_at
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_pizza_we_want_to_update_is_not_found()
    {
        $this->json('PUT', 'pizza/-1');

        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_update_a_pizza()
    {
        $pizza = $this->create('Pizza');
        $priceSmall = $pizza->small;
        $priceMedium = $pizza->medium;
        $priceLarge = $pizza->large;
        $response = $this->json('PUT', "pizzas/$pizza->id", [
            'name' => $pizza->name . '_updated',
            'description' => $pizza->description . '_updated',
            'small' => $pizza->small + 10,
            'medium' => $pizza->medium + 10,
            'large' => $pizza->large + 10
        ]);

        $response->seeJsonEquals([
            'id' => $pizza->id,
            'name' => $pizza->name . '_updated',
            'description' => $pizza->description . '_updated',
            'small' => $priceSmall + 10,
            'medium' => $priceMedium + 10,
            'large' => $priceLarge + 10,
            'created_at' => (string) $pizza->created_at
        ])->assertResponseStatus(200);

        $this->seeInDatabase('pizzas', [
            'id' => $pizza->id,
            'description' => $pizza->description . '_updated',
            'small' => $priceSmall + 10,
            'medium' => $priceMedium + 10,
            'large' => $priceLarge + 10,
            'created_at' => (string) $pizza->created_at
        ]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_pizza_we_want_to_delete_is_not_found()
    {
        $response = $this->json('DELETE', 'pizzas/-1');

        $response->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_delete_a_pizza()
    {
        $pizza = $this->create('Pizza');
        $this->json('DELETE', "pizzas/$pizza->id");
        $this->assertResponseStatus(204);
        $this->notSeeInDatabase('pizzas', ['id' => $pizza->id]);
    }

}
