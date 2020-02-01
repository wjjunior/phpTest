<?php

namespace Wjjunior\Parking\Models;

interface SpaceInterface
{
    public function getVehicle(): Vehicle;
    public function setVehicle(Vehicle $vehicle): Space;
    public function getEntranceHour(): string;
    public function setEntranceHour(string $entranceHour): Space;
    public function getExitHour(): string;
    public function setExitHour(string $exitHour): Space;
}
