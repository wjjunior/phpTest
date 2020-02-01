<?php

namespace Wjjunior\FlightTicket\Models;

use Wjjunior\FlightTicket\Models\PaymentInterface;

class Payment implements PaymentInterface
{

    private $flightOutbound;
    private $flightInbound;

    public function __construct(Flight $flightOutbound, Flight $flightInbound)
    {
        $this->flightOutbound = $flightOutbound;
        $this->flightInbound = $flightInbound;
    }

    /**
     * Get the value of flightOutbound
     */
    public function getFlightOutbound(): Flight
    {
        return $this->flightOutbound;
    }

    /**
     * Set the value of flightOutbound
     *
     * @return  self
     */
    public function setFlightOutbound(Flight $flightOutbound): Payment
    {
        $this->flightOutbound = $flightOutbound;

        return $this;
    }

    /**
     * Get the value of flightInbound
     */
    public function getFlightInbound(): Flight
    {
        return $this->flightInbound;
    }

    /**
     * Set the value of flightInbound
     *
     * @return  self
     */
    public function setFlightInbound(Flight $flightInbound): Payment
    {
        $this->flightInbound = $flightInbound;

        return $this;
    }

    /**
     * Generates the flight statement
     *
     * @return object
     */
    public function generateExtract(): object
    {
        $valorTotal = $this->flightOutbound->calculateFlightTotal();
        $flightDetailsOutbound = [
            'De' => $this->flightOutbound->getDepartureAirport(),
            'Para' => $this->flightOutbound->getArrivalAirport(),
            'Embarque' => $this->flightOutbound->getDepartureTime()->format('d/m/Y H:i'),
            'Desembarque' => $this->flightOutbound->getArrivalTime()->format('d/m/Y H:i'),
            'Cia' => $this->flightOutbound->getCia(),
            'Valor' => $this->flightOutbound->calculateFlightTotal(),
            'Serviços' => $this->formatServices($this->flightOutbound->getCargo())
        ];
        $flightDetailsInbound = [];
        if (!is_null($this->flightInbound)) {
            $valorTotal += $this->flightInbound->calculateFlightTotal();
            $flightDetailsInbound = [
                'De' => $this->flightInbound->getDepartureAirport(),
                'Para' => $this->flightInbound->getArrivalAirport(),
                'Embarque' => $this->flightInbound->getDepartureTime()->format('d/m/Y H:i'),
                'Desembarque' => $this->flightInbound->getArrivalTime()->format('d/m/Y H:i'),
                'Cia' => $this->flightInbound->getCia(),
                'Valor' => $this->flightInbound->calculateFlightTotal(),
                'Serviços' => $this->formatServices($this->flightInbound->getCargo())
            ];
        }
        return (object) [
            'flightOutbound' => $flightDetailsOutbound,
            'flightInbound' => $flightDetailsInbound,
            'valorTotal' => $valorTotal
        ];
    }

    /**
     * Formats services for extract
     *
     * @param array $cargos
     * @return array
     */
    private function formatServices(array $cargos): array
    {
        $services = [];
        foreach ($cargos as $cargo) {
            array_push($services, [
                'Descrição' => $cargo->getDescription(),
                'Peso' => $cargo->getWeight(),
                'Preço' => $cargo->getPrice()
            ]);
        }
        return $services;
    }
}
