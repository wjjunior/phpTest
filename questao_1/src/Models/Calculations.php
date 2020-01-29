<?php

namespace Wjjunior\Calculations\Models;

class Calculations
{
    public static function quadraticEquation(float $a, float $b, float $c): string
    {
        if ($a == 0) {
            throw new \InvalidArgumentException("Não é uma equação de segundo grau\n");
        }
        
        $delta = (float) $b * $b - 4 * $a * $c;

        if ($delta == 0) {
            return "x = " . -$b / 2 / $a . "\n";
        } else if ($delta > 0) {
            return "x = " . (-$b + sqrt($delta)) / 2 / $a . "\nx = " . (-$b - sqrt($delta)) / 2 / $a . "\n";
        } else {
            return "A equação não possui raízes exatas\n";
        }
    }
}
