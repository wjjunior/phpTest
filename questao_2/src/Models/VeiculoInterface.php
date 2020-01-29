<?php

namespace Wjjunior\Estacionamento\Models;

interface VeiculoInterface
{
    public function getTipo(): string;
    public function setTipo(string $tipo): Veiculo;
    public function getPlaca(): string;
    public function setPlaca(string $placa): Veiculo;
}
