<?php

require_once __DIR__.'/vendor/autoload.php';

use Wjjunior\Calculations\Models\Calculations;

echo "Informe o valor de 'a':\n";
$a = (float) fgets(STDIN);

echo "Informe o valor de 'b':\n";
$b = (float) fgets(STDIN);

echo "Informe o valor de 'c':\n";
$c = (float) fgets(STDIN);


echo Calculations::quadraticEquation($a, $b, $c);
