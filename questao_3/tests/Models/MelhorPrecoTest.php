<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\MelhorPreco\Models\MelhorPreco;

class MelhorPrecoTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_melhor_preco_asserts()
    {
        $texts = [
            "Melhor preço sem escalas R$ 1.367(1) Melhor preço com escalas R$ 994 (1) 1 - Incluindo todas as taxas.",
            "Melhor preço sem escalas R$ 392(1) Melhor preço com escalas R$ 1.000 (1) 1 - Incluindo todas as taxas.",
            "Melhor preço sem escalas R$ 401,50(1) Melhor preço com escalas R$ 1.200,30 (1) 1 - Incluindo todas as taxas.",
        ];

        $this->assertEquals("994.00", MelhorPreco::calculaMelhorPreco($texts[0]));
        $this->assertEquals("392.00", MelhorPreco::calculaMelhorPreco($texts[1]));
        $this->assertEquals("401.50", MelhorPreco::calculaMelhorPreco($texts[2]));
    }

    /**
     * @test
     */
    public function test_melhor_preco_invalid_string()
    {
        $text = "Melhor preço sem escalas R$ Melhor preço com escalas R$ ";

        $this->expectException(\InvalidArgumentException::class);

        MelhorPreco::calculaMelhorPreco($text);
    }
}
