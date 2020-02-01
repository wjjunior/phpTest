<?php

use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ClientControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_return_a_collection_of_paginated_clients()
    {
        for ($i = 0; $i <= 3; $i++) {
            $this->create('Client');
        }

        $this->json('GET', '/clients');

        $this->assertResponseStatus(200);
        $this->seeJsonStructure([
            '*' => ['id', 'name', 'phone_number', 'address', 'reference', 'created_at']
        ]);
    }

    /**
     * @test
     */
    public function can_create_a_client()
    {

        $faker = Factory::create();

        $response = $this->json('POST', '/clients', [
            'name' => $name = $faker->name,
            'phone_number' => $phone = $faker->unique()->phoneNumber,
            'address' => $address = $faker->address
        ]);

        $response->seeJsonStructure(
            ['id', 'name', 'phone_number', 'address', 'reference', 'created_at']
        )
            ->seeJsonContains([
                'name' => $name,
                'phone_number' => $phone,
                'address' => $address,
                'reference' => null
            ])->assertResponseStatus(201);

        $this->seeInDatabase('clients', [
            'name' => $name,
            'phone_number' => $phone,
            'address' => $address
        ]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_client_is_not_found()
    {
        $this->json('GET', 'clients/-1');

        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_return_a_client()
    {
        $client = $this->create('Client');
        $this->json('GET', "clients/$client->id");
        $this->seeJsonEquals([
            'id' => $client->id,
            'name' => $client->name,
            'phone_number' => $client->phone_number,
            'address' => $client->address,
            'reference' => $client->reference,
            'created_at' => (string) $client->created_at
        ])->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_client_we_want_to_update_is_not_found()
    {
        $this->json('PUT', 'client/-1');

        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_update_a_client()
    {
        $client = $this->create('Client');

        $response = $this->json('PUT', "clients/$client->id", [
            'name' => $client->name . '_updated',
            'phone_number' => $client->phone_number . '_1',
            'address' => $client->address . '_updated'
        ]);

        $response->seeJsonEquals([
            'id' => $client->id,
            'name' => $client->name . '_updated',
            'phone_number' => $client->phone_number . '_1',
            'address' => $client->address . '_updated',
            "reference" => null,
            'created_at' => (string) $client->created_at
        ])->assertResponseStatus(200);

        $this->seeInDatabase('clients', [
            'id' => $client->id,
            'name' => $client->name . '_updated',
            'phone_number' => $client->phone_number . '_1',
            'address' => $client->address . '_updated',
            "reference" => null,
            'created_at' => (string) $client->created_at
        ]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_client_we_want_to_delete_is_not_found()
    {
        $response = $this->json('DELETE', 'clients/-1');

        $response->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_delete_a_client()
    {
        $client = $this->create('Client');
        $this->json('DELETE', "clients/$client->id");
        $this->assertResponseStatus(204);
        $this->notSeeInDatabase('clients', ['id' => $client->id]);
    }

    /**
     * @test
     */
    public function will_fail_with_a_404_if_client_not_found()
    {
        $this->json('GET', 'clients/-1/orders');
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function can_list_client_orders()
    {
        $client = $this->create('Client');

        for ($i = 0; $i <= 3; $i++) {
            $this->create('Order', [
                'client_id' => $client->id
            ]);
        }

        $this->json('GET', "/clients/$client->id/orders");

        $this->assertResponseStatus(200);
        $this->seeJsonStructure([
            '*' => ['id', 'client', 'status', 'arrival', 'total', 'pizzas', 'note']
        ]);

    }
}
