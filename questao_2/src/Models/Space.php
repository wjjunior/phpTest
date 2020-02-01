<?php

namespace Wjjunior\Parking\Models;

class Space implements SpaceInterface
{
    private $vehicle;
    private $entranceHour;
    private $exitHour;

    public function __construct(object $vehicle, string $entranceHour, string $exitHour = null)
    {
        $this->vehicle = $vehicle;
        $this->entranceHour = $entranceHour;
        $this->exitHour = $exitHour;
    }

    /**
     * Returns the vehicle occupying the vacancy
     *
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * Sets the vehicle occupying the vacancy
     *
     * @return  self
     */
    public function setVehicle(Vehicle $vehicle): Space
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Returns the entry time
     *
     * @return string
     */
    public function getEntranceHour(): string
    {
        return $this->entranceHour;
    }

    /**
     * Sets the entry time
     *
     * @param string $entranceHour
     * @return self
     */
    public function setEntranceHour(string $entranceHour): Space
    {
        $this->entranceHour = $entranceHour;

        return $this;
    }

    /**
     * Returns the exit time
     *
     * @return string
     */
    public function getExitHour(): string
    {
        return $this->exitHour;
    }

    /**
     * Sets the exit time
     *
     * @return  self
     */
    public function setExitHour(string $exitHour): Space
    {
        $this->exitHour = $exitHour;

        return $this;
    }
}
