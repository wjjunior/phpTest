<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\FlightTicket\Models\Cargo;

class CargoTest extends TestCase
{
    private $cargo;
    private $faker;


    public function setUp(): void
    {
        $this->faker = Faker\Factory::create();
        $this->cargo = new Cargo($this->faker->words(3, true), $this->faker->randomFloat(2, 1, 100), $this->faker->randomFloat(2, 1, 100), $this->faker->randomElement(['liveload', 'baggage']));
    }

    /**
     * @test
     */
    public function test_if_description_can_be_assign()
    {

        $description = $this->faker->words(3, true);
        $this->cargo->setDescription($description);

        $this->assertEquals($description, $this->cargo->getDescription());
    }

    /**
     * @test
     */
    public function test_if_price_can_be_assign()
    {

        $price = $this->faker->randomFloat(2, 1, 100);
        $this->cargo->setPrice($price);

        $this->assertEquals($price, $this->cargo->getPrice());
    }

    /**
     * @test
     */
    public function test_if_weigth_can_be_assign()
    {

        $weight = $this->faker->randomFloat(2, 1, 100);
        $this->cargo->setWeight($weight);

        $this->assertEquals($weight, $this->cargo->getWeight());
    }

    /**
     * @test
     */
    public function test_if_type_can_be_assign()
    {
        $type = $this->faker->randomElement(['liveload', 'baggage']);
        $this->cargo->setType($type);

        $this->assertEquals($type, $this->cargo->getType());
    }
}
