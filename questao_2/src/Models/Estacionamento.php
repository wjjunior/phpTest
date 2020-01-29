<?php

namespace Wjjunior\Estacionamento\Models;

use Wjjunior\Estacionamento\Models\Vaga;
use DateTime;

class Estacionamento implements EstacionamentoInterface
{
    private $vagasDisponiveis;
    private $precos;
    private $veiculosEstacionados;

    public function __construct(array $estacionamento)
    {
        $this->vagasDisponiveis = $estacionamento['vagas'];
        $this->precos = $estacionamento['preco'];
        $this->veiculosEstacionados = [];
    }

    /**
     * Retorna os veículos estacionados
     *
     * @return array
     */
    public function getVeiculosEstacionados(): array
    {
        return $this->veiculosEstacionados;
    }

    /**
     * Define o array de veículos estacionados
     *
     * @return  self
     */
    public function setVeiculosEstacionados(array $veiculosEstacionados): Estacionamento
    {
        $this->veiculosEstacionados = $veiculosEstacionados;

        return $this;
    }

    /**
     * Retorna a quantidade de vagas disponíveis
     *
     * @return array
     */
    public function getVagasDisponiveis(): array
    {
        return $this->vagasDisponiveis;
    }

    /**
     * Valida placa de um veículo e verifica se já esta presente no estacionamento
     *
     * @param string $placa
     * @param boolean $saida
     * @return boolean
     */
    public function validarPlaca(string $placa, bool $saida = false): bool
    {
        if (!preg_match('/^[A-Z]{3}\-[0-9]{4}$/', $placa)) {
            echo "Placa inválida!\n";
            return false;
        } elseif (!$saida) {
            $localizarPlaca = $this->localizarVeiculo($placa);
            if ($localizarPlaca) {
                echo "Este veículo ja esta estacionado.\n";
                return false;
            }
        }
        return true;
    }

    /**
     * Localiza o veículo no estacionamento pela placa
     *
     * @param string $placa
     * @return Vaga|null
     */
    public function localizarVeiculo(string $placa): ?Vaga
    {
        $vaga = array_filter($this->veiculosEstacionados, function (Vaga $obj) use ($placa) {
            $objVeiculo = $obj->getVeiculo();
            return $objVeiculo->getPlaca() === $placa ? true : false;
        });

        if (count($vaga)) {
            return array_shift($vaga);
        } else {
            return null;
        }
    }

    /**
     * Adiciona um veículo ao estacionamento
     *
     * @param Veiculo $veiculo
     * @return string
     */
    public function entradaVeiculo(Veiculo $veiculo): string
    {
        $veiculoTipo = $veiculo->getTipo();
        $vaga = new Vaga($veiculo, date("Y-m-d H:i:s"));

        if ($this->vagasDisponiveis[$veiculoTipo] > 0) {
            array_push($this->veiculosEstacionados, $vaga);
            --$this->vagasDisponiveis[$veiculoTipo];
            return "Entrada liberada!\n";
        } else {
            return "Nenhuma vaga disponível\n";
        }
    }

    /**
     * Calcula o valor a pagar do cliente
     *
     * @param integer $minutos
     * @param string $veiculoTipo
     * @return float
     */
    public function calcularPagamento(int $minutos, string $veiculoTipo): float
    {
        $total = 0;
        do {
            foreach ($this->precos[$veiculoTipo] as $tempo => $valor) {
                if ($minutos <= $tempo) {
                    $total += $valor;
                    $minutos = 0;
                    break;
                } elseif ($tempo === array_key_last($this->precos[$veiculoTipo])) {
                    $total += $valor;
                    $minutos -= $tempo;
                }
            }
        } while ($minutos > 0);

        return $total;
    }

    /**
     * Calcula o tempo do veículo estacionado
     *
     * @param Vaga $vaga
     * @return integer
     */
    public function tempoEstacionado(Vaga $vaga): int
    {
        $horaEntrada = new DateTime($vaga->getHoraEntrada());
        $horaSaida = new Datetime();
        $vaga->setHoraSaida($horaSaida->format("Y-m-d H:i:s"));
        $interval = $horaEntrada->diff($horaSaida);
        return $interval->h * 60 + $interval->i;
    }

    /**
     * Remove o veículo do estacionamento
     *
     * @param Veiculo $veiculo
     * @return void
     */
    public function removeVeiculo(Veiculo $veiculo): void
    {
        $placa = $veiculo->getPlaca();
        $veiculosEstacionados = array_filter($this->veiculosEstacionados, function (Vaga $obj) use ($placa) {
            $objVeiculo = $obj->getVeiculo();
            return $objVeiculo->getPlaca() !== $placa ? true : false;
        });
        ++$this->vagasDisponiveis[$veiculo->getTipo()];
        $this->setVeiculosEstacionados($veiculosEstacionados);
    }

    /**
     * Remove o veículo do estacionamento e imprime os dados para pagamento
     *
     * @param string $placa
     * @return string
     */
    public function saidaVeiculo(string $placa): string
    {
        $vaga = $this->localizarVeiculo($placa);

        if (!$vaga) {
            return "Veículo não encontrado no estacionamento.\n";
        }

        $veiculo = $vaga->getVeiculo();

        $minutos = $this->tempoEstacionado($vaga);

        $total = $this->calcularPagamento($minutos, $veiculo->getTipo());

        $this->removeVeiculo($veiculo);

        $dataAtual = new DateTime();
        $horaEntrada = new DateTime($vaga->getHoraEntrada());
        $horaSaida = new DateTime($vaga->getHoraSaida());

        return "VALOR: R$" . $total . "\nPLACA DO VEÍCULO: " . $veiculo->getPlaca() . "\nDATA: " . $dataAtual->format("d/m/Y") . "\nHORÁRIO DE ENTRADA: " . $horaEntrada->format("d/m/Y - H:i:s") . "\nHORÁRIO DE SAÍDA: " . $horaSaida->format("d/m/Y - H:i:s") . "\n";
    }
}
