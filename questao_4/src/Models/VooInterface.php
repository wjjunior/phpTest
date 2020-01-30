<?php

namespace Wjjunior\PassagemAerea\Models;

interface VooInterface
{
    public function getCodigo(): string;
    public function setCodigo(string $codigo): Voo;
    public function getAeroportoSaida(): string;
    public function setAeroportoSaida(string $aeroportoSaida): Voo;
    public function getAeroportoChegada(): string;
    public function setAeroportoChegada(string $aeroportoChegada): Voo;
    public function getHorarioSaida(): DateTime;
    public function setHorarioSaida(DateTime $horarioSaida): Voo;
    public function getHorarioChegada(): DateTime;
    public function setHorarioChegada(DateTime $horarioChegada): Voo;
    public function getValorTotal(): float;
    public function setValorTotal(float $valorTotal): Voo;
    public function getBagagens(): array;
    public function setBagagens(array $bagagens): Voo;
    public function getCargasVivas(): array;
    public function setCargasVivas(array $cargasVivas): Voo;
}
