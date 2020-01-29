<?php

namespace Wjjunior\Estacionamento\Models;

interface EstacionamentoInterface
{
    public function getVeiculosEstacionados(): array;
    public function setVeiculosEstacionados(array $veiculosEstacionados): Estacionamento;
    public function getVagasDisponiveis(): array;
    public function validarPlaca(string $placa, bool $saida): bool;
    public function localizarVeiculo(string $placa): ?Vaga;
    public function entradaVeiculo(Veiculo $veiculo): string;
    public function calcularPagamento(int $minutos, string $veiculoTipo): float;
    public function tempoEstacionado(Vaga $vaga): int;
    public function removeVeiculo(Veiculo $veiculo): void;
    public function saidaVeiculo(string $placa): string;
}
