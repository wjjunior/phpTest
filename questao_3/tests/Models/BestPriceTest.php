<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\BestPrice\Models\BestPrice;

class BestPriceTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_best_price_asserts()
    {
        $texts = [
            "Melhor preço sem escalas R$ 1.367(1) Melhor preço com escalas R$ 994 (1) 1 - Incluindo todas as taxas.",
            "Melhor preço sem escalas R$ 392(1) Melhor preço com escalas R$ 1.000 (1) 1 - Incluindo todas as taxas.",
            "Melhor preço sem escalas R$ 401,50(1) Melhor preço com escalas R$ 1.200,30 (1) 1 - Incluindo todas as taxas.",
        ];

        $this->assertEquals("994.00", BestPrice::calculateBestPrice($texts[0]));
        $this->assertEquals("392.00", BestPrice::calculateBestPrice($texts[1]));
        $this->assertEquals("401.50", BestPrice::calculateBestPrice($texts[2]));
    }

    /**
     * @test
     */
    public function test_best_price_invalid_string()
    {
        $text = "Melhor preço sem escalas R$ Melhor preço com escalas R$ ";

        $this->expectException(\InvalidArgumentException::class);

        BestPrice::calculateBestPrice($text);
    }
}
