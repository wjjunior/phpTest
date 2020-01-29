<?php

namespace Wjjunior\MelhorPreco\Models;

interface MelhorPrecoInterface
{
    public static function calculaMelhorPreco(string $text): float;
}
