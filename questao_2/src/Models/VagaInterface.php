<?php

namespace Wjjunior\Estacionamento\Models;

interface VagaInterface
{
    public function getVeiculo(): Veiculo;
    public function setVeiculo(Veiculo $veiculo): Vaga;
    public function getHoraEntrada(): string;
    public function setHoraEntrada(string $horaEntrada): Vaga;
    public function getHoraSaida(): string;
    public function setHoraSaida(string $horaSaida): Vaga;
}
