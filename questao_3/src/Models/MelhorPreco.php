<?php

namespace Wjjunior\MelhorPreco\Models;

class MelhorPreco implements MelhorPrecoInterface
{
    /**
     * Calcula o melhor preço encontrado em uma string
     *
     * @param string $text
     * @return float
     */
    public static function calculaMelhorPreco(string $text): float
    {
        $pattern = '/(R\$ )([0-9]+\.)?[0-9]+(,[0-9]{2})?(?= *\(.+\))?/';

        preg_match_all($pattern, $text, $matches);

        if(!count($matches[0])) {
            throw new \InvalidArgumentException("Nenhum preço encontrado no texto");
        }

        $precos = array_map(function ($preco) {
            return (float) str_replace(',', '.', preg_replace('/[^0-9,]+/', '', $preco));
        }, $matches[0]);

        return min($precos);
    }
}
