<?php

namespace Wjjunior\PassagemAerea\Models;

abstract class AbstractCarga
{
    protected $descricao;
    protected $preco;
    protected $peso;

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao($descricao): object
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function setPreco(float $preco): object
    {
        $this->preco = $preco;

        return $this;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): object
    {
        $this->peso = $peso;

        return $this;
    }
}
