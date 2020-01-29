<?php

require_once __DIR__ . '/vendor/autoload.php';

use Wjjunior\MelhorPreco\Models\MelhorPreco;

$text = "Melhor preço sem escalas R$ 1.367(1) Melhor preço com escalas R$ 994 (1) 1 - Incluindo todas as taxas.";

echo number_format(MelhorPreco::calculaMelhorPreco($text), 2)."\n";
