<?php

use PHPUnit\Framework\TestCase;
use Wjjunior\Estacionamento\Models\Estacionamento;
use Wjjunior\Estacionamento\Models\Vaga;
use Wjjunior\Estacionamento\Models\Veiculo;

class EstacionamentoTest extends TestCase
{
    protected static $config;

    public static function setUpBeforeClass(): void
    {
        self::$config = require("config.php");
    }

    /**
     * @test
     */
    public function test_if_veiculos_estacionados_can_be_assign()
    {
        $estacionamento = new Estacionamento(self::$config);
        $vaga = new Vaga(new Veiculo('carro', 'ABC-1234'), date("Y-m-d H:i:s"));
        $estacionamento->setVeiculosEstacionados([$vaga]);
        $this->assertContains($vaga, $estacionamento->getVeiculosEstacionados());
    }

    /**
     * @test
     */
    public function test_if_vagas_disponiveis_can_be_retrieved()
    {
        $estacionamento = new Estacionamento(self::$config);
        $this->assertEquals(self::$config['vagas'], $estacionamento->getVagasDisponiveis());
    }

    /**
     * @test
     */
    public function test_validar_placa_entrada()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'ABC-1234';
        $this->assertTrue($estacionamento->validarPlaca($placa));
    }

    /**
     * @test
     */
    public function test_validar_placa_entrada_utilizada()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'ABC-1234';
        $estacionamento->entradaVeiculo(new Veiculo('carro', $placa));
        $this->assertFalse($estacionamento->validarPlaca($placa));
    }

    /**
     * @test
     */
    public function test_validar_placa_entrada_invalida()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'abc';
        $this->assertFalse($estacionamento->validarPlaca($placa));
    }

    /**
     * @test
     */
    public function test_validar_placa_saida()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'ABC-1234';
        $this->assertTrue($estacionamento->validarPlaca($placa, true));
    }

    /**
     * @test
     */
    public function test_validar_placa_saida_utilizada()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'ABC-1234';
        $estacionamento->entradaVeiculo(new Veiculo('carro', $placa));
        $this->assertTrue($estacionamento->validarPlaca($placa, true));
    }

    /**
     * @test
     */
    public function test_validar_placa_saida_invalida()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'abc';
        $this->assertFalse($estacionamento->validarPlaca($placa, false));
    }

    /**
     * @test
     */
    public function test_localizar_veiculo()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'ABC-1234';
        $estacionamento->entradaVeiculo(new Veiculo('carro', $placa));
        $this->assertInstanceOf(Vaga::class, $estacionamento->localizarVeiculo($placa));
    }

    /**
     * @test
     */
    public function test_localizar_veiculo_null()
    {
        $estacionamento = new Estacionamento(self::$config);
        $placa = 'ABC-1234';
        $this->assertNull($estacionamento->localizarVeiculo($placa));
    }

    /**
     * @test
     */
    public function test_entrada_veiculo()
    {
        $estacionamento = new Estacionamento(self::$config);
        $this->assertEquals("Entrada liberada!\n", $estacionamento->entradaVeiculo(new Veiculo('carro', 'ABC-1234')));
        $vagasCarroConfig = self::$config['vagas']['carro'];
        $this->assertEquals(--$vagasCarroConfig, $estacionamento->getVagasDisponiveis()['carro']);
    }

    /**
     * @test
     */
    public function test_entrada_veiculo_sem_vagas()
    {
        $config = self::$config;
        $config['vagas']['carro'] = 0;
        $estacionamento = new Estacionamento($config);
        $this->assertEquals("Nenhuma vaga disponível\n", $estacionamento->entradaVeiculo(new Veiculo('carro', 'ABC-1234')));
    }

    /**
     * @test
     */
    public function test_calcular_pagamento()
    {
        $estacionamento = new Estacionamento(self::$config);
        $this->assertEquals(3.25, $estacionamento->calcularPagamento(5, 'carro'));
        $this->assertEquals(6.5, $estacionamento->calcularPagamento(25, 'carro'));
        $this->assertEquals(9.75, $estacionamento->calcularPagamento(40, 'carro'));
        $this->assertEquals(13, $estacionamento->calcularPagamento(55, 'carro'));
        $this->assertEquals(39, $estacionamento->calcularPagamento(174, 'carro'));

        $this->assertEquals(1.75, $estacionamento->calcularPagamento(5, 'moto'));
        $this->assertEquals(3.5, $estacionamento->calcularPagamento(25, 'moto'));
        $this->assertEquals(5.25, $estacionamento->calcularPagamento(40, 'moto'));
        $this->assertEquals(7, $estacionamento->calcularPagamento(55, 'moto'));
        $this->assertEquals(21, $estacionamento->calcularPagamento(174, 'moto'));
    }

    /**
     * @test
     */
    public function test_tempo_estacionado()
    {
        $estacionamento = new Estacionamento(self::$config);
        $minutes = strtotime('-174 minutes');
        $vaga = new Vaga(new Veiculo('carro', 'ABC-1234'), date("Y-m-d H:i:s", $minutes));
        $this->assertEquals(174, $estacionamento->tempoEstacionado($vaga));
    }

    /**
     * @test
     */
    public function test_remove_veiculo()
    {
        $estacionamento = new Estacionamento(self::$config);
        $veiculo = new Veiculo('carro', 'ABC-1234');
        $estacionamento->entradaVeiculo($veiculo);
        $estacionamento->removeVeiculo($veiculo);
        $this->assertCount(0, $estacionamento->getVeiculosEstacionados());
        $this->assertEquals(self::$config['vagas']['carro'], $estacionamento->getVagasDisponiveis()['carro']);
    }

    /**
     * @test
     */
    public function test_saida_veiculo()
    {
        $placa = 'ABC-1234';
        $estacionamento = new Estacionamento(self::$config);
        $veiculo = new Veiculo('carro', $placa);
        $estacionamento->entradaVeiculo($veiculo);
        $vaga = $estacionamento->localizarVeiculo($placa);
        $saida = $estacionamento->saidaVeiculo($placa);
        $dataAtual = new DateTime();
        $horaEntrada = new DateTime($vaga->getHoraEntrada());
        $horaSaida = new DateTime($vaga->getHoraSaida());
        $minutos = $estacionamento->tempoEstacionado($vaga);
        $total = $estacionamento->calcularPagamento($minutos, $veiculo->getTipo());
        $this->assertEquals("VALOR: R$" . $total . "\nPLACA DO VEÍCULO: " . $veiculo->getPlaca() . "\nDATA: " . $dataAtual->format("d/m/Y") . "\nHORÁRIO DE ENTRADA: " . $horaEntrada->format("d/m/Y - H:i:s") . "\nHORÁRIO DE SAÍDA: " . $horaSaida->format("d/m/Y - H:i:s") . "\n", $saida);
    }

    /**
     * @test
     */
    public function test_saida_veiculo_nao_encontrado()
    {
        $placa = 'ABC-1234';
        $estacionamento = new Estacionamento(self::$config);
        $saida = $estacionamento->saidaVeiculo($placa);

        $this->assertEquals("Veículo não encontrado no estacionamento.\n", $saida);
    }
}
