<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\Estacionamento\Models\Vaga;
use Wjjunior\Estacionamento\Models\Veiculo;

class VagaTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_veiculo_can_be_assign()
    {
        $veiculo = new Veiculo('carro', 'ABC-1234');
        $vaga = new Vaga($veiculo, date("Y-m-d H:i:s"));
        $vaga->setVeiculo(new Veiculo('moto', 'PGU-1234'));

        $this->assertInstanceOf(Veiculo::class, $vaga->getVeiculo());
    }

    /**
     * @test
     */
    public function test_if_horaEntrada_can_be_assign()
    {
        
        $vaga = new Vaga(new Veiculo('carro', 'ABC-1234'), date("Y-m-d H:i:s"));
        $horaEntrada = new DateTime('2020-01-01 10:00:00');
        $vaga->setHoraEntrada($horaEntrada->format("Y-m-d H:i:s"));

        $this->assertEquals($horaEntrada->format("Y-m-d H:i:s"), $vaga->getHoraEntrada());
    }

    /**
     * @test
     */
    public function test_if_horaSaida_can_be_assign()
    {
        
        $vaga = new Vaga(new Veiculo('carro', 'ABC-1234'), date("Y-m-d H:i:s"));
        $horaSaida = new DateTime('2020-02-01 10:00:00');
        $vaga->setHoraSaida($horaSaida->format("Y-m-d H:i:s"));

        $this->assertEquals($horaSaida->format("Y-m-d H:i:s"), $vaga->getHoraSaida());
    }
}