<?php

namespace Wjjunior\FlightTicket\Models;

interface PaymentInterface
{
    public function getFlightOutbound(): Flight;
    public function setFlightOutbound(Flight $flightOutbound): Payment;
    public function getFlightInbound(): Flight;
    public function setFlightInbound(Flight $flightInbound): Payment;
    public function generateExtract(): object;
}
