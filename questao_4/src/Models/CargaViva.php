<?php

namespace Wjjunior\PassagemAerea\Models;

use Wjjunior\Estacionamento\Models\CargaVivaInterface;

class CargaViva extends AbstractCarga implements CargaVivaInterface
{
    public function __construct(string $descricao, float $preco, float $peso)
    {
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->peso = $peso;
    }
}
