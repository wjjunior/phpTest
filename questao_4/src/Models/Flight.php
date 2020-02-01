<?php

namespace Wjjunior\FlightTicket\Models;

use DateTime;
use Wjjunior\FlightTicket\Models\FlightInterface;

class Flight implements FlightInterface
{
    private $code;
    private $cia;
    private $departureAirport;
    private $arrivalAirport;
    private $departureTime;
    private $arrivalTime;
    private $ticketsTotal;
    private $cargo;

    public function __construct(
        string $code,
        string $cia,
        string $departureAirport,
        string $arrivalAirport,
        DateTime $departureTime,
        DateTime $arrivalTime,
        float $ticketsTotal
    ) {
        $this->code = $code;
        $this->cia = $cia;
        $this->departureAirport = $departureAirport;
        $this->arrivalAirport = $arrivalAirport;
        $this->departureTime = $departureTime;
        $this->arrivalTime = $arrivalTime;
        $this->ticketsTotal = $ticketsTotal;
        $this->cargo = [];
    }

    /**
     * Get the value of code
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode(string $code): Flight
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of cia
     */
    public function getCia(): string
    {
        return $this->cia;
    }

    /**
     * Set the value of cia
     *
     * @return  self
     */
    public function setCia(string $cia): Flight
    {
        $this->cia = $cia;

        return $this;
    }

    /**
     * Get the value of departureAirport
     */
    public function getDepartureAirport(): string
    {
        return $this->departureAirport;
    }

    /**
     * Set the value of departureAirport
     *
     * @return  self
     */
    public function setDepartureAirport(string $departureAirport): Flight
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    /**
     * Get the value of arrivalAirport
     */
    public function getArrivalAirport(): string
    {
        return $this->arrivalAirport;
    }

    /**
     * Set the value of arrivalAirport
     *
     * @return  self
     */
    public function setArrivalAirport(string $arrivalAirport): Flight
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }

    /**
     * Get the value of departureTime
     */
    public function getDepartureTime(): DateTime
    {
        return $this->departureTime;
    }

    /**
     * Set the value of departureTime
     *
     * @return  self
     */
    public function setDepartureTime(DateTime $departureTime): Flight
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    /**
     * Get the value of arrivalTime
     */
    public function getArrivalTime(): DateTime
    {
        return $this->arrivalTime;
    }

    /**
     * Set the value of arrivalTime
     *
     * @return  self
     */
    public function setArrivalTime(DateTime $arrivalTime): Flight
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTicketsTotal(): float
    {
        return $this->ticketsTotal;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTicketsTotal(float $ticketsTotal): Flight
    {
        $this->ticketsTotal = $ticketsTotal;

        return $this;
    }

    /**
     * Get the value of cargo
     */
    public function getCargo(): array
    {
        return $this->cargo;
    }

    /**
     * Set the value of cargo
     *
     * @return  self
     */
    public function setCargo(array $cargo): Flight
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Add a new cargo to flight
     *
     * @param Cargo $cargo
     * @return Flight
     */
    public function addCargo(Cargo $cargo): Flight
    {
        $type = $cargo->getType();
        if ($type !== 'baggage' && $type !== 'liveload') {
            throw new \InvalidArgumentException("Tipo de carga inválido");
        }
        $this->setCargo(array_merge($this->getCargo(), [$cargo->getId() => $cargo]));
        return $this;
    }

    /**
     * Remove the cargo from flight
     *
     * @param string $id
     * @return Flight
     */
    public function removeCargo(string $id): Flight
    {
        $cargo = $this->getCargo();
        if (!array_key_exists($id, $cargo)) {
            throw new \InvalidArgumentException("Id não encontrado");
        }
        unset($cargo[$id]);
        $this->setCargo($cargo);
        return $this;
    }

    /**
     * Calculate the flight total including cargos
     *
     * @return float
     */
    public function calculateFlightTotal(): float
    {
        $total = $this->getTicketsTotal();
        $total += array_reduce($this->getCargo(), function($price, $cargo) {
            $price += $cargo->getPrice();
            return $price;
          });

        return $total;
    }
}
