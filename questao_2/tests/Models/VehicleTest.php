<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\Parking\Models\Vehicle;

class VehicleTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_type_can_be_assign()
    {
        $vehicle = new Vehicle('carro', 'ABC-1234');
        $vehicle->setType('moto');

        $this->assertEquals('moto', $vehicle->getType());
    }

    /**
     * @test
     */
    public function test_if_plate_can_be_assign()
    {

        $vehicle = new Vehicle('carro', 'ABC-1234');
        $vehicle->setPlaca('CBA-4321');

        $this->assertEquals('CBA-4321', $vehicle->getPlate());
    }
}
