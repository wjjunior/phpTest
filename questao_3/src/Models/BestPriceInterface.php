<?php

namespace Wjjunior\BestPrice\Models;

interface BestPriceInterface
{
    public static function calculateBestPrice(string $text): float;
}
