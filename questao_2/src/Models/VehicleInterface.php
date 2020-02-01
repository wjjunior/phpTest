<?php

namespace Wjjunior\Parking\Models;

interface VehicleInterface
{
    public function getType(): string;
    public function setType(string $type): Vehicle;
    public function getPlate(): string;
    public function setPlaca(string $plate): Vehicle;
}
