<?php

namespace Wjjunior\Parking\Models;

use Wjjunior\Parking\Models\Space;
use DateTime;

class Parking implements ParkingInterface
{
    private $availableSpaces;
    private $prices;
    private $parkedVehicles;

    public function __construct(array $parking)
    {
        $this->availableSpaces = $parking['spaces'];
        $this->prices = $parking['price'];
        $this->parkedVehicles = [];
    }

    /**
     * Return parked vehicles
     *
     * @return array
     */
    public function getParkedVehicles(): array
    {
        return $this->parkedVehicles;
    }

    /**
     * Set parked vehicles array
     *
     * @return  self
     */
    public function setParkedVehicles(array $parkedVehicles): Parking
    {
        $this->parkedVehicles = $parkedVehicles;

        return $this;
    }

    /**
     * Return available spaces quantity
     *
     * @return array
     */
    public function getAvailableSpaces(): array
    {
        return $this->availableSpaces;
    }

    /**
     * Validates a vehicle's plate and checks if it is already present in the parking lot
     *
     * @param string $plate
     * @param boolean $exit
     * @return boolean
     */
    public function plateValidation(string $plate, bool $exit = false): bool
    {
        if (!preg_match('/^[A-Z]{3}\-[0-9]{4}$/', $plate)) {
            echo "Placa inválida!\n";
            return false;
        } elseif (!$exit) {
            $findPlate = $this->findVehicle($plate);
            if ($findPlate) {
                echo "Este veículo ja esta estacionado.\n";
                return false;
            }
        }
        return true;
    }

    /**
     * Locate the vehicle in the parking lot by the plate
     *
     * @param string $plate
     * @return Space|null
     */
    public function findVehicle(string $plate): ?Space
    {
        $space = array_filter($this->parkedVehicles, function (Space $obj) use ($plate) {
            $objVehicle = $obj->getVehicle();
            return $objVehicle->getPlate() === $plate ? true : false;
        });

        if (count($space)) {
            return array_shift($space);
        } else {
            return null;
        }
    }

    /**
     * Adds a vehicle to the parking lot
     *
     * @param Vehicle $vehicle
     * @return string
     */
    public function vehicleEntrance(Vehicle $vehicle): string
    {
        $vehicleType = $vehicle->getType();
        $space = new Space($vehicle, date("Y-m-d H:i:s"));

        if ($this->availableSpaces[$vehicleType] > 0) {
            array_push($this->parkedVehicles, $space);
            --$this->availableSpaces[$vehicleType];
            return "Entrada liberada!\n";
        } else {
            return "Nenhuma space disponível\n";
        }
    }

    /**
     * Calculates the customer's payable amount
     *
     * @param integer $minutes
     * @param string $vehicleType
     * @return float
     */
    public function paymentCalculation(int $minutes, string $vehicleType): float
    {
        $total = 0;
        do {
            foreach ($this->prices[$vehicleType] as $time => $value) {
                if ($minutes <= $time) {
                    $total += $value;
                    $minutes = 0;
                    break;
                } elseif ($time === array_key_last($this->prices[$vehicleType])) {
                    $total += $value;
                    $minutes -= $time;
                }
            }
        } while ($minutes > 0);

        return $total;
    }

    /**
     * Calculates the time of the parked vehicle
     *
     * @param Space $space
     * @return integer
     */
    public function parkedTime(Space $space): int
    {
        $entranceHour = new DateTime($space->getEntranceHour());
        $exitHour = new Datetime();
        $space->setExitHour($exitHour->format("Y-m-d H:i:s"));
        $interval = $entranceHour->diff($exitHour);
        return $interval->h * 60 + $interval->i;
    }

    /**
     * Removes the vehicle from the parking lot
     *
     * @param Vehicle $vehicle
     * @return void
     */
    public function removeVehicle(Vehicle $vehicle): void
    {
        $plate = $vehicle->getPlate();
        $parkedVehicles = array_filter($this->parkedVehicles, function (Space $obj) use ($plate) {
            $objVehicle = $obj->getVehicle();
            return $objVehicle->getPlate() !== $plate ? true : false;
        });
        ++$this->availableSpaces[$vehicle->getType()];
        $this->setParkedVehicles($parkedVehicles);
    }

    /**
     * Remove the vehicle from the parking lot and print the payment details
     *
     * @param string $plate
     * @return string
     */
    public function exitVehicle(string $plate): string
    {
        $space = $this->findVehicle($plate);

        if (!$space) {
            return "Veículo não encontrado no parking.\n";
        }

        $vehicle = $space->getVehicle();

        $minutes = $this->parkedTime($space);

        $total = $this->paymentCalculation($minutes, $vehicle->getType());

        $this->removeVehicle($vehicle);

        $currentDate = new DateTime();
        $entranceHour = new DateTime($space->getEntranceHour());
        $exitHour = new DateTime($space->getExitHour());

        return "VALOR: R$" . $total . "\nPLACA DO VEÍCULO: " . $vehicle->getPlate() . "\nDATA: " . $currentDate->format("d/m/Y") . "\nHORÁRIO DE ENTRADA: " . $entranceHour->format("d/m/Y - H:i:s") . "\nHORÁRIO DE SAÍDA: " . $exitHour->format("d/m/Y - H:i:s") . "\n";
    }
}
