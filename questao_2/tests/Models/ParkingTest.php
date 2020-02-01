<?php

use PHPUnit\Framework\TestCase;
use Wjjunior\Parking\Models\Parking;
use Wjjunior\Parking\Models\Space;
use Wjjunior\Parking\Models\Vehicle;

class ParkingTest extends TestCase
{
    protected static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = require("config.php");
    }

    /**
     * @test
     */
    public function test_if_vehicle_estacionados_can_be_assign()
    {
        $parking = new Parking(self::$config);
        $space = new Space(new Vehicle('carro', 'ABC-1234'), date("Y-m-d H:i:s"));
        $parking->setParkedVehicles([$space]);
        $this->assertContains($space, $parking->getParkedVehicles());
    }

    /**
     * @test
     */
    public function test_if_spaces_disponiveis_can_be_retrieved()
    {
        $parking = new Parking(self::$config);
        $this->assertEquals(self::$config['spaces'], $parking->getAvailableSpaces());
    }

    /**
     * @test
     */
    public function test_validar_plate_entrada()
    {
        $parking = new Parking(self::$config);
        $plate = 'ABC-1234';
        $this->assertTrue($parking->plateValidation($plate));
    }

    /**
     * @test
     */
    public function test_validar_plate_entrada_utilizada()
    {
        $parking = new Parking(self::$config);
        $plate = 'ABC-1234';
        $parking->vehicleEntrance(new Vehicle('carro', $plate));
        $this->assertFalse($parking->plateValidation($plate));
    }

    /**
     * @test
     */
    public function test_validar_plate_entrada_invalida()
    {
        $parking = new Parking(self::$config);
        $plate = 'abc';
        $this->assertFalse($parking->plateValidation($plate));
    }

    /**
     * @test
     */
    public function test_validar_plate_exit()
    {
        $parking = new Parking(self::$config);
        $plate = 'ABC-1234';
        $this->assertTrue($parking->plateValidation($plate, true));
    }

    /**
     * @test
     */
    public function test_validar_plate_exit_utilizada()
    {
        $parking = new Parking(self::$config);
        $plate = 'ABC-1234';
        $parking->vehicleEntrance(new Vehicle('carro', $plate));
        $this->assertTrue($parking->plateValidation($plate, true));
    }

    /**
     * @test
     */
    public function test_validar_plate_exit_invalida()
    {
        $parking = new Parking(self::$config);
        $plate = 'abc';
        $this->assertFalse($parking->plateValidation($plate, false));
    }

    /**
     * @test
     */
    public function test_localizar_vehicle()
    {
        $parking = new Parking(self::$config);
        $plate = 'ABC-1234';
        $parking->vehicleEntrance(new Vehicle('carro', $plate));
        $this->assertInstanceOf(Space::class, $parking->findVehicle($plate));
    }

    /**
     * @test
     */
    public function test_localizar_vehicle_null()
    {
        $parking = new Parking(self::$config);
        $plate = 'ABC-1234';
        $this->assertNull($parking->findVehicle($plate));
    }

    /**
     * @test
     */
    public function test_entrada_vehicle()
    {
        $parking = new Parking(self::$config);
        $this->assertEquals("Entrada liberada!\n", $parking->vehicleEntrance(new Vehicle('carro', 'ABC-1234')));
        $spacesCarroConfig = self::$config['spaces']['carro'];
        $this->assertEquals(--$spacesCarroConfig, $parking->getAvailableSpaces()['carro']);
    }

    /**
     * @test
     */
    public function test_entrada_vehicle_sem_spaces()
    {
        $config = self::$config;
        $config['spaces']['carro'] = 0;
        $parking = new Parking($config);
        $this->assertEquals("Nenhuma space disponível\n", $parking->vehicleEntrance(new Vehicle('carro', 'ABC-1234')));
    }

    /**
     * @test
     */
    public function test_calcular_pagamento()
    {
        $parking = new Parking(self::$config);
        $this->assertEquals(3.25, $parking->paymentCalculation(5, 'carro'));
        $this->assertEquals(6.5, $parking->paymentCalculation(25, 'carro'));
        $this->assertEquals(9.75, $parking->paymentCalculation(40, 'carro'));
        $this->assertEquals(13, $parking->paymentCalculation(55, 'carro'));
        $this->assertEquals(39, $parking->paymentCalculation(174, 'carro'));

        $this->assertEquals(1.75, $parking->paymentCalculation(5, 'moto'));
        $this->assertEquals(3.5, $parking->paymentCalculation(25, 'moto'));
        $this->assertEquals(5.25, $parking->paymentCalculation(40, 'moto'));
        $this->assertEquals(7, $parking->paymentCalculation(55, 'moto'));
        $this->assertEquals(21, $parking->paymentCalculation(174, 'moto'));
    }

    /**
     * @test
     */
    public function test_time_estacionado()
    {
        $parking = new Parking(self::$config);
        $minutes = strtotime('-174 minutes');
        $space = new Space(new Vehicle('carro', 'ABC-1234'), date("Y-m-d H:i:s", $minutes));
        $this->assertEquals(174, $parking->parkedTime($space));
    }

    /**
     * @test
     */
    public function test_remove_vehicle()
    {
        $parking = new Parking(self::$config);
        $vehicle = new Vehicle('carro', 'ABC-1234');
        $parking->vehicleEntrance($vehicle);
        $parking->removeVehicle($vehicle);
        $this->assertCount(0, $parking->getParkedVehicles());
        $this->assertEquals(self::$config['spaces']['carro'], $parking->getAvailableSpaces()['carro']);
    }

    /**
     * @test
     */
    public function test_exit_vehicle()
    {
        $plate = 'ABC-1234';
        $parking = new Parking(self::$config);
        $vehicle = new Vehicle('carro', $plate);
        $parking->vehicleEntrance($vehicle);
        $space = $parking->findVehicle($plate);
        $exit = $parking->exitVehicle($plate);
        $currentDate = new DateTime();
        $entranceHour = new DateTime($space->getEntranceHour());
        $exitHour = new DateTime($space->getExitHour());
        $minutes = $parking->parkedTime($space);
        $total = $parking->paymentCalculation($minutes, $vehicle->getType());
        $this->assertEquals("VALOR: R$" . $total . "\nPLACA DO VEÍCULO: " . $vehicle->getPlate() . "\nDATA: " . $currentDate->format("d/m/Y") . "\nHORÁRIO DE ENTRADA: " . $entranceHour->format("d/m/Y - H:i:s") . "\nHORÁRIO DE SAÍDA: " . $exitHour->format("d/m/Y - H:i:s") . "\n", $exit);
    }

    /**
     * @test
     */
    public function test_exit_vehicle_nao_encontrado()
    {
        $plate = 'ABC-1234';
        $parking = new Parking(self::$config);
        $exit = $parking->exitVehicle($plate);

        $this->assertEquals("Veículo não encontrado no parking.\n", $exit);
    }
}
