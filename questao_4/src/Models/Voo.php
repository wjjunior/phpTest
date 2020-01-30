<?php

namespace Wjjunior\PassagemAerea\Models;

use DateTime;
use Wjjunior\Estacionamento\Models\VooInterface;

class Voo implements VooInterface
{
    private $codigo;
    private $aeroportoSaida;
    private $aeroportoChegada;
    private $horarioSaida;
    private $horarioChegada;
    private $valorTotal;
    private $bagagens;
    private $cargasVivas;

    public function __construct(
        string $codigo,
        string $aeroportoSaida,
        string $aeroportoChegada,
        DateTime $horarioSaida,
        DateTime $horarioChegada,
        float $valorTotal
    ) {
        $this->codigo = $codigo;
        $this->aeroportoSaida = $aeroportoSaida;
        $this->aeroportoChegada = $aeroportoChegada;
        $this->horarioSaida = $horarioSaida;
        $this->horarioChegada = $horarioChegada;
        $this->valorTotal = $valorTotal;
        $this->bagagens = [];
        $this->cargasVivas = [];
    }

    /**
     * Get the value of codigo
     */
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */
    public function setCodigo(string $codigo): Voo
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of aeroportoSaida
     */
    public function getAeroportoSaida(): string
    {
        return $this->aeroportoSaida;
    }

    /**
     * Set the value of aeroportoSaida
     *
     * @return  self
     */
    public function setAeroportoSaida(string $aeroportoSaida): Voo
    {
        $this->aeroportoSaida = $aeroportoSaida;

        return $this;
    }

    /**
     * Get the value of aeroportoChegada
     */
    public function getAeroportoChegada(): string
    {
        return $this->aeroportoChegada;
    }

    /**
     * Set the value of aeroportoChegada
     *
     * @return  self
     */
    public function setAeroportoChegada(string $aeroportoChegada): Voo
    {
        $this->aeroportoChegada = $aeroportoChegada;

        return $this;
    }

    /**
     * Get the value of horarioSaida
     */
    public function getHorarioSaida(): DateTime
    {
        return $this->horarioSaida;
    }

    /**
     * Set the value of horarioSaida
     *
     * @return  self
     */
    public function setHorarioSaida(DateTime $horarioSaida): Voo
    {
        $this->horarioSaida = $horarioSaida;

        return $this;
    }

    /**
     * Get the value of horarioChegada
     */
    public function getHorarioChegada(): DateTime
    {
        return $this->horarioChegada;
    }

    /**
     * Set the value of horarioChegada
     *
     * @return  self
     */
    public function setHorarioChegada(DateTime $horarioChegada): Voo
    {
        $this->horarioChegada = $horarioChegada;

        return $this;
    }

    /**
     * Get the value of valorTotal
     */
    public function getValorTotal(): float
    {
        return $this->valorTotal;
    }

    /**
     * Set the value of valorTotal
     *
     * @return  self
     */
    public function setValorTotal(float $valorTotal): Voo
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get the value of bagagens
     */
    public function getBagagens(): array
    {
        return $this->bagagens;
    }

    /**
     * Set the value of bagagens
     *
     * @return  self
     */
    public function setBagagens(array $bagagens): Voo
    {
        $this->bagagens = $bagagens;

        return $this;
    }

    /**
     * Get the value of cargasVivas
     */
    public function getCargasVivas(): array
    {
        return $this->cargasVivas;
    }

    /**
     * Set the value of cargasVivas
     *
     * @return  self
     */
    public function setCargasVivas(array $cargasVivas): Voo
    {
        $this->cargasVivas = $cargasVivas;

        return $this;
    }
}
