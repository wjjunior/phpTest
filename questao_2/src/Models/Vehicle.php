<?php

namespace Wjjunior\Parking\Models;

class Vehicle implements VehicleInterface
{
    public function __construct(string $type, string $plate)
    {
        $this->type = $type;
        $this->plate = $plate;
    }

    /**
     * Returns the vehicle type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the vehicle type
     *
     * @return  self
     */
    public function setType(string $type): Vehicle
    {
        $this->type = $type;

        return $this;
    }


    /**
     * Returns the vehicle plate
     *
     * @return string
     */
    public function getPlate(): string
    {
        return $this->plate;
    }

    /**
     * Sets the vehicle plate
     *
     * @return  self
     */
    public function setPlaca(string $plate): Vehicle
    {
        $this->plate = $plate;

        return $this;
    }
}
