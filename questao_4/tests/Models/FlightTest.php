<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\FlightTicket\Models\Flight;
use Wjjunior\FlightTicket\Models\Cargo;

class FlightTest extends TestCase
{
    private $flight;
    private $faker;


    public function setUp(): void
    {
        $this->faker = Faker\Factory::create();
        $this->flight = new Flight(
            $this->faker->randomNumber(8),
            $this->faker->word(),
            $this->faker->company(),
            $this->faker->company(),
            $this->faker->dateTime(),
            $this->faker->dateTime(),
            $this->faker->randomFloat(2, 100, 400),
        );
    }

    /**
     * @test
     */
    public function test_if_code_can_be_assign()
    {

        $code = $this->faker->randomNumber(8);
        $this->flight->setCode($code);

        $this->assertEquals($code, $this->flight->getCode());
    }

    /**
     * @test
     */
    public function test_if_cia_can_be_assign()
    {

        $cia = $this->faker->word();
        $this->flight->setCia($cia);

        $this->assertEquals($cia, $this->flight->getCia());
    }

    /**
     * @test
     */
    public function test_if_departure_airport_can_be_assign()
    {

        $dpAirport = $this->faker->company();
        $this->flight->setDepartureAirport($dpAirport);

        $this->assertEquals($dpAirport, $this->flight->getDepartureAirport());
    }

    /**
     * @test
     */
    public function test_if_arrival_airport_can_be_assign()
    {

        $arrAirport = $this->faker->company();
        $this->flight->setArrivalAirport($arrAirport);

        $this->assertEquals($arrAirport, $this->flight->getArrivalAirport());
    }

    /**
     * @test
     */
    public function test_if_departure_time_can_be_assign()
    {

        $dpTime = $this->faker->dateTime();
        $this->flight->setDepartureTime($dpTime);

        $this->assertEquals($dpTime, $this->flight->getDepartureTime());
    }

    /**
     * @test
     */
    public function test_if_arrival_time_can_be_assign()
    {

        $arrTime = $this->faker->dateTime();
        $this->flight->setArrivalTime($arrTime);

        $this->assertEquals($arrTime, $this->flight->getArrivalTime());
    }



    /**
     * @test
     */
    public function test_if_tickets_total_can_be_assign()
    {

        $ticketsTotal = $this->faker->randomFloat(2, 100, 400);
        $this->flight->setTicketsTotal($ticketsTotal);

        $this->assertEquals($ticketsTotal, $this->flight->getTicketsTotal());
    }

    /**
     * @test
     */
    public function test_if_can_add_cargo_to_flight()
    {

        $cargo = new Cargo($this->faker->words(3, true), $this->faker->randomFloat(2, 1, 100), $this->faker->randomFloat(2, 1, 100), $this->faker->randomElement(['liveload', 'baggage']));

        $this->flight->addCargo($cargo);

        $this->assertContains($cargo, $this->flight->getCargo());
    }

    /**
     * @test
     */
    public function test_if_cargo_type_is_valid()
    {

        $cargo = new Cargo($this->faker->words(3, true), $this->faker->randomFloat(2, 1, 100), $this->faker->randomFloat(2, 1, 100), $this->faker->word());

        $this->expectException(\InvalidArgumentException::class);

        $this->flight->addCargo($cargo);
    }

    /**
     * @test
     */
    public function test_if_can_remove_cargo_to_flight()
    {

        $cargo = new Cargo($this->faker->words(3, true), $this->faker->randomFloat(2, 1, 100), $this->faker->randomFloat(2, 1, 100), $this->faker->randomElement(['liveload', 'baggage']));

        $this->flight->addCargo($cargo);
        $this->assertContains($cargo, $this->flight->getCargo());

        $this->flight->removeCargo($cargo->getId());

        $this->assertNotContains($cargo, $this->flight->getCargo());
    }

    /**
     * @test
     */
    public function test_if_can_calculate_flight_total()
    {

        $cargo = new Cargo($this->faker->words(3, true), $this->faker->randomFloat(2, 1, 100), $this->faker->randomFloat(2, 1, 100), $this->faker->randomElement(['liveload', 'baggage']));

        $this->flight->addCargo($cargo);
        $this->assertContains($cargo, $this->flight->getCargo());

        $total = $this->flight->getTicketsTotal() + $cargo->getPrice();

        $this->assertEquals($total, $this->flight->calculateFlightTotal());
    }
}
