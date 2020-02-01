<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\Parking\Models\Space;
use Wjjunior\Parking\Models\Vehicle;

class SpaceTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_vehicle_can_be_assign()
    {
        $vehicle = new Vehicle('carro', 'ABC-1234');
        $space = new Space($vehicle, date("Y-m-d H:i:s"));
        $space->setVehicle(new Vehicle('moto', 'PGU-1234'));

        $this->assertInstanceOf(Vehicle::class, $space->getVehicle());
    }

    /**
     * @test
     */
    public function test_if_entranceHour_can_be_assign()
    {
        
        $space = new Space(new Vehicle('carro', 'ABC-1234'), date("Y-m-d H:i:s"));
        $entranceHour = new DateTime('2020-01-01 10:00:00');
        $space->setEntranceHour($entranceHour->format("Y-m-d H:i:s"));

        $this->assertEquals($entranceHour->format("Y-m-d H:i:s"), $space->getEntranceHour());
    }

    /**
     * @test
     */
    public function test_if_exitHour_can_be_assign()
    {
        
        $space = new Space(new Vehicle('carro', 'ABC-1234'), date("Y-m-d H:i:s"));
        $exitHour = new DateTime('2020-02-01 10:00:00');
        $space->setExitHour($exitHour->format("Y-m-d H:i:s"));

        $this->assertEquals($exitHour->format("Y-m-d H:i:s"), $space->getExitHour());
    }
}