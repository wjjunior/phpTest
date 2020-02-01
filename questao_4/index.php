<?php

require_once __DIR__ . '/vendor/autoload.php';

use Wjjunior\FlightTicket\Models\Flight;
use Wjjunior\FlightTicket\Models\Cargo;
use Wjjunior\FlightTicket\Models\Payment;

$departureTime = new DateTime('2020-02-01T19:00:00');
$departureTime2 = new DateTime('2020-02-10T09:00:00');
$arrivalTime = new DateTime('2020-02-02T23:00:00');
$arrivalTime2 = new DateTime('2020-02-10T14:00:00');

$flight = new Flight('12345', 'TAM', 'Confins', 'Galeão', $departureTime, $arrivalTime, 450);
$flight2 = new Flight('12346', 'Azul', 'Galeão', 'Confins', $departureTime2, $arrivalTime2, 700);

$cargo = new Cargo('Gato', 120, 10, 'liveload');
$cargo2 = new Cargo('Mala', 50, 12, 'baggage');

$flight->addCargo($cargo);
$flight2->addCargo($cargo2);

$payment = new Payment($flight, $flight2);

print_r($payment->generateExtract());
