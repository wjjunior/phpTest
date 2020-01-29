<?php

namespace Wjjunior\Estacionamento\Models;

class Vaga implements VagaInterface
{
    private $veiculo;
    private $horaEntrada;
    private $horaSaida;

    public function __construct(object $veiculo, string $horaEntrada, string $horaSaida = null)
    {
        $this->veiculo = $veiculo;
        $this->horaEntrada = $horaEntrada;
        $this->horaSaida = $horaSaida;
    }

    /**
     * Retorna o veículo ocupante da vaga
     *
     * @return Veiculo
     */
    public function getVeiculo(): Veiculo
    {
        return $this->veiculo;
    }

    /**
     * Define o veículo ocupante da vaga
     *
     * @return  self
     */
    public function setVeiculo(Veiculo $veiculo): Vaga
    {
        $this->veiculo = $veiculo;

        return $this;
    }

    /**
     * Retorna a hora de entrada
     *
     * @return string
     */
    public function getHoraEntrada(): string
    {
        return $this->horaEntrada;
    }

    /**
     * Define a hora de entrada
     *
     * @param string $horaEntrada
     * @return self
     */
    public function setHoraEntrada(string $horaEntrada): Vaga
    {
        $this->horaEntrada = $horaEntrada;

        return $this;
    }

    /**
     * Retorna a hora de saída
     *
     * @return string
     */
    public function getHoraSaida(): string
    {
        return $this->horaSaida;
    }

    /**
     * Define a hora de saída
     *
     * @return  self
     */
    public function setHoraSaida(string $horaSaida): Vaga
    {
        $this->horaSaida = $horaSaida;

        return $this;
    }
}
