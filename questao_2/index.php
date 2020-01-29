<?php

require_once __DIR__ . '/vendor/autoload.php';

use Wjjunior\Estacionamento\Models\Estacionamento;
use Wjjunior\Estacionamento\Models\Veiculo;

$config = include('config.php');

$estacionamento = new Estacionamento($config);

echo "Estacionamento 123Milhas\n.................................\n";

do {
    echo "[1]Entrada de veículos\n[2]Saída de veículos\n[3]Veículos estacionados\n[9]Sair\n";
    echo "Informe uma opção:\n";
    $opcao = (int) fgets(STDIN);

    switch ($opcao) {
        case 1:
            entradaVeiculo($estacionamento);
            break;
        case 2:
            saidaVeiculo($estacionamento);
            break;
        case 3:
            listarVeiculos($estacionamento);
            break;
        case 9:
            die();
            break;
        default:
            echo "Opção inválida!\n";
            break;
    }
} while ($opcao !== 9);



function entradaVeiculo(Estacionamento $estacionamento): void
{

    do {
        echo "Informe a placa do veículo:\n";
        $placa = strtoupper(trim(fgets(STDIN)));
    } while (!$estacionamento->validarPlaca($placa));

    do {
        echo "Informe o tipo do veículo (moto ou carro):\n";
        $tipo = trim((string) fgets(STDIN));
        if ($tipo !== "moto" && $tipo !== "carro") {
            echo "Tipo inválido\n";
        }
    } while ($tipo !== "moto" && $tipo !== "carro");

    $veiculo = new Veiculo($tipo, $placa);

    echo $estacionamento->entradaVeiculo($veiculo) . ".................................\n";
}

function saidaVeiculo(Estacionamento $estacionamento): void
{
    do {
        echo "Informe a placa do veículo:\n";
        $placa = strtoupper(trim(fgets(STDIN)));
    } while (!$estacionamento->validarPlaca($placa, true));

    echo $estacionamento->saidaVeiculo($placa) . ".................................\n";
}

function listarVeiculos(Estacionamento $estacionamento): void
{
    $mask = "|%10.10s |%-10.10s | %-30.30s |\n";
    printf($mask, 'Placa', 'Tipo', 'Entrada');

    foreach ($estacionamento->getVeiculosEstacionados() as $vaga) {
        $horaEntrada = new DateTime($vaga->getHoraEntrada());
        $veiculo = $vaga->getVeiculo();
        printf($mask, $veiculo->getPlaca(), ucfirst($veiculo->getTipo()), $horaEntrada->format("d/m/Y - H:i:s"));
    }

    echo ".................................\n";
}
