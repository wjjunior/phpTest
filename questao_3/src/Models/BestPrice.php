<?php

namespace Wjjunior\BestPrice\Models;

class BestPrice implements BestPriceInterface
{
    /**
     * Calcula o melhor preço encontrado em uma string
     *
     * @param string $text
     * @return float
     */
    public static function calculateBestPrice(string $text): float
    {
        $pattern = '/(R\$ )([0-9]+\.)?[0-9]+(,[0-9]{2})?(?= *\(.+\))?/';

        preg_match_all($pattern, $text, $matches);

        if(!count($matches[0])) {
            throw new \InvalidArgumentException("Nenhum preço encontrado no texto");
        }

        $prices = array_map(function ($price) {
            return (float) str_replace(',', '.', preg_replace('/[^0-9,]+/', '', $price));
        }, $matches[0]);

        return min($prices);
    }
}
