<?php

namespace Wjjunior\FlightTicket\Models;

use DateTime;

interface FlightInterface
{
    public function getCodigo(): string;
    public function setCodigo(string $code): Flight;
    public function getCia(): string;
    public function setCia(string $cia): Flight;
    public function getDepartureAirport(): string;
    public function setDepartureAirport(string $departureAirport): Flight;
    public function getArrivalAirport(): string;
    public function setArrivalAirport(string $arrivalAirport): Flight;
    public function getDepartureTime(): DateTime;
    public function setDepartureTime(DateTime $departureTime): Flight;
    public function getArrivalTime(): DateTime;
    public function setArrivalTime(DateTime $arrivalTime): Flight;
    public function getTicketsTotal(): float;
    public function setTicketsTotal(float $ticketsTotal): Flight;
    public function getCargo(): array;
    public function setCargo(array $cargo): Flight;
    public function addCargo(Cargo $cargo): Flight;
    public function removeCargo(string $id): Flight;
    public function calculateFlightTotal(): float;
}
