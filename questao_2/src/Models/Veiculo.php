<?php

namespace Wjjunior\Estacionamento\Models;

class Veiculo implements VeiculoInterface
{
    public function __construct(string $tipo, string $placa)
    {
        $this->tipo = $tipo;
        $this->placa = $placa;
    }

    /**
     * Retorna o tipo do veículo
     *
     * @return string
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Define o tipo do veículo
     *
     * @return  self
     */
    public function setTipo(string $tipo): Veiculo
    {
        $this->tipo = $tipo;

        return $this;
    }


    /**
     * Retorna a placa do veículo
     *
     * @return string
     */
    public function getPlaca(): string
    {
        return $this->placa;
    }

    /**
     * Define a placa do veículo
     *
     * @return  self
     */
    public function setPlaca(string $placa): Veiculo
    {
        $this->placa = $placa;

        return $this;
    }
}
