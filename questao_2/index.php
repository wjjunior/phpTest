<?php

require_once __DIR__ . '/vendor/autoload.php';

use Wjjunior\Parking\Models\Parking;
use Wjjunior\Parking\Models\Vehicle;

$config = include('config.php');

$parking = new Parking($config);

echo "Estacionamento 123Milhas\n.................................\n";

do {
    echo "[1]Entrada de veículos\n[2]Saída de veículos\n[3]Veículos estacionados\n[9]Sair\n";
    echo "Informe uma opção:\n";
    $opcao = (int) fgets(STDIN);

    switch ($opcao) {
        case 1:
            vehicleEntrance($parking);
            break;
        case 2:
            exitVehicle($parking);
            break;
        case 3:
            listVehicles($parking);
            break;
        case 9:
            die();
            break;
        default:
            echo "Opção inválida!\n";
            break;
    }
} while ($opcao !== 9);



function vehicleEntrance(Parking $parking): void
{

    do {
        echo "Informe a plate do veículo:\n";
        $plate = strtoupper(trim(fgets(STDIN)));
    } while (!$parking->plateValidation($plate));

    do {
        echo "Informe o tipo do veículo (moto ou carro):\n";
        $type = trim((string) fgets(STDIN));
        if ($type !== "moto" && $type !== "carro") {
            echo "Tipo inválido\n";
        }
    } while ($type !== "moto" && $type !== "carro");

    $vehicle = new Vehicle($type, $plate);

    echo $parking->vehicleEntrance($vehicle) . ".................................\n";
}

function exitVehicle(Parking $parking): void
{
    do {
        echo "Informe a placa do veículo:\n";
        $plate = strtoupper(trim(fgets(STDIN)));
    } while (!$parking->plateValidation($plate, true));

    echo $parking->exitVehicle($plate) . ".................................\n";
}

function listVehicles(Parking $parking): void
{
    $mask = "|%10.10s |%-10.10s | %-30.30s |\n";
    printf($mask, 'Placa', 'Tipo', 'Entrada');

    foreach ($parking->getParkedVehicles() as $space) {
        $entranceHour = new DateTime($space->getEntranceHour());
        $vehicle = $space->getVehicle();
        printf($mask, $vehicle->getPlate(), ucfirst($vehicle->getType()), $entranceHour->format("d/m/Y - H:i:s"));
    }

    echo ".................................\n";
}
