<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\FlightTicket\Models\Flight;
use Wjjunior\FlightTicket\Models\Cargo;
use Wjjunior\FlightTicket\Models\Payment;

class PaymentTest extends TestCase
{
    private $payment;
    private $faker;
    private $flightInbound;
    private $flightOutbound;


    public function setUp(): void
    {
        $this->faker = Faker\Factory::create();
        $this->flightInbound = $this->generateFlight();
        $this->flightOutbound = $this->generateFlight();
        $this->payment = new Payment($this->flightOutbound, $this->flightInbound);
    }

    private function generateFlight(): Flight
    {
        $flight = new Flight(
            $this->faker->randomNumber(8),
            $this->faker->word(),
            $this->faker->company(),
            $this->faker->company(),
            $this->faker->dateTime(),
            $this->faker->dateTime(),
            $this->faker->randomFloat(2, 100, 400),
        );

        for ($i = 0; $i <= rand(1, 3); $i++) {
            $flight->addCargo(new Cargo($this->faker->words(3, true), $this->faker->randomFloat(2, 1, 100), $this->faker->randomFloat(2, 1, 100), $this->faker->randomElement(['liveload', 'baggage'])));
        }

        return $flight;
    }

    /**
     * @test
     */
    public function test_if_flight_outbound_can_be_assign()
    {

        $flight = $this->generateFlight();
        $this->payment->setFlightOutbound($flight);

        $this->assertEquals($flight, $this->payment->getFlightOutbound());
    }

    /**
     * @test
     */
    public function test_if_flight_inbound_can_be_assign()
    {

        $flight = $this->generateFlight();
        $this->payment->setFlightInbound($flight);

        $this->assertEquals($flight, $this->payment->getFlightInbound());
    }

    /**
     * @test
     */
    public function test_if_can_generate_extract()
    {
        $payment = $this->payment->generateExtract();
        $this->assertObjectHasAttribute('flightOutbound', $payment);
        $this->assertObjectHasAttribute('flightInbound', $payment);
        $this->assertObjectHasAttribute('valorTotal', $payment);
    }

    /**
     * @test
     */
    public function test_extract_flight_outbound_info()
    {
        $payment = $this->payment->generateExtract();

        $this->assertEquals($this->flightOutbound->getDepartureAirport(),$payment->flightOutbound['De']);
        $this->assertEquals($this->flightOutbound->getArrivalAirport(),$payment->flightOutbound['Para']);
        $this->assertEquals($this->flightOutbound->getDepartureTime()->format('d/m/Y H:i'),$payment->flightOutbound['Embarque']);
        $this->assertEquals($this->flightOutbound->getArrivalTime()->format('d/m/Y H:i'),$payment->flightOutbound['Desembarque']);
        $this->assertEquals($this->flightOutbound->getCia(),$payment->flightOutbound['Cia']);
        $this->assertEquals($this->flightOutbound->calculateFlightTotal(),$payment->flightOutbound['Valor']);
        $this->assertArrayHasKey('Serviços', $payment->flightOutbound);
    }

    /**
     * @test
     */
    public function test_extract_flight_inbound_info()
    {
        $payment = $this->payment->generateExtract();

        $this->assertEquals($this->flightInbound->getDepartureAirport(),$payment->flightInbound['De']);
        $this->assertEquals($this->flightInbound->getArrivalAirport(),$payment->flightInbound['Para']);
        $this->assertEquals($this->flightInbound->getDepartureTime()->format('d/m/Y H:i'),$payment->flightInbound['Embarque']);
        $this->assertEquals($this->flightInbound->getArrivalTime()->format('d/m/Y H:i'),$payment->flightInbound['Desembarque']);
        $this->assertEquals($this->flightInbound->getCia(),$payment->flightInbound['Cia']);
        $this->assertEquals($this->flightInbound->calculateFlightTotal(),$payment->flightInbound['Valor']);
        $this->assertArrayHasKey('Serviços', $payment->flightInbound);
    }

    /**
     * @test
     */
    public function test_if_extract_total_value_is_correct()
    {
        $payment = $this->payment->generateExtract();

        $valorTotal = $this->flightOutbound->calculateFlightTotal() + $this->flightInbound->calculateFlightTotal();

        $this->assertEquals($valorTotal, $payment->valorTotal);
    }
}
