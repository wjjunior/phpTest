<?php

use PHPUnit\Framework\TestCase;

use Wjjunior\Calculations\Models\Calculations;

class CalculationsTest extends TestCase
{
    /**
     * @test
     */
    public function test_if_quadratic_equation_has_two_coeficients()
    {
        $a = 1;
        $b = -5;
        $c = 6;

        $this->assertEquals("x = 3\nx = 2\n", Calculations::quadraticEquation($a, $b, $c));
    }

    /**
     * @test
     */
    public function test_if_quadratic_equation_has_one_coeficient()
    {
        $a = 4;
        $b = -4;
        $c = 1;

        $this->assertEquals("x = 0.5\n", Calculations::quadraticEquation($a, $b, $c));
    }

    /**
     * @test
     */
    public function test_if_quadratic_equation_has_no_coeficient()
    {
        $a = 5;
        $b = 1;
        $c = 6;

        $this->assertEquals("A equação não possui raízes exatas\n", Calculations::quadraticEquation($a, $b, $c));
    }

    /**
     * @test
     */
    public function test_if_whether_the_argument_is_valid()
    {
        $a = 0;
        $b = 1;
        $c = 6;

        $this->expectException(\InvalidArgumentException::class);

        Calculations::quadraticEquation($a, $b, $c);
    }
}
