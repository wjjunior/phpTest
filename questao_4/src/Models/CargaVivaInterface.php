<?php

namespace Wjjunior\PassagemAerea\Models;

interface CargaVivaInterface
{
    public function getDescricao(): string;
    public function setDescricao(string $string): object;
    public function getPreco(): float;
    public function setPreco(float $preco): object;
    public function getPeso(): string;
    public function setPeso(float $peso): object;
}
