<?php

namespace Wjjunior\Parking\Models;

interface ParkingInterface
{
    public function getParkedVehicles(): array;
    public function setParkedVehicles(array $parkedVehicles): Parking;
    public function getAvailableSpaces(): array;
    public function plateValidation(string $plate, bool $exit): bool;
    public function findVehicle(string $plate): ?Space;
    public function vehicleEntrance(Vehicle $vehicle): string;
    public function paymentCalculation(int $minutes, string $vehicleType): float;
    public function parkedTime(Space $space): int;
    public function removeVehicle(Vehicle $vehicle): void;
    public function exitVehicle(string $plate): string;
}
