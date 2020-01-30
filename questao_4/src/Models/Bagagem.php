<?php

namespace Wjjunior\PassagemAerea\Models;

use Wjjunior\Estacionamento\Models\BagagemInterface;

class Bagagem extends AbstractCarga implements BagagemInterface
{
    public function __construct(string $descricao, float $preco, float $peso)
    {
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->peso = $peso;
    }
}
