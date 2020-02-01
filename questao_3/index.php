<?php

require_once __DIR__ . '/vendor/autoload.php';

use Wjjunior\BestPrice\Models\BestPrice;

$text = "Melhor preço sem escalas R$ 1.367(1) Melhor preço com escalas R$ 994 (1) 1 - Incluindo todas as taxas.";

echo number_format(BestPrice::calculateBestPrice($text), 2)."\n";
