<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\Estacionamento\Models\Veiculo;

class VeiculoTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_tipo_can_be_assign()
    {
        $veiculo = new Veiculo('carro', 'ABC-1234');
        $veiculo->setTipo('moto');

        $this->assertEquals('moto', $veiculo->getTipo());
    }

    /**
     * @test
     */
    public function test_if_placa_can_be_assign()
    {

        $veiculo = new Veiculo('carro', 'ABC-1234');
        $veiculo->setPlaca('CBA-4321');

        $this->assertEquals('CBA-4321', $veiculo->getPlaca());
    }
}
