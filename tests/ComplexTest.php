<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require_once 'Complex.php';


/**
 * Run all tests: ./vendor/bin/phpunit tests
 */
final class ComplexTest extends TestCase
{    
    /**
     * Выполняем суммирование и сверяем вывод.
     *
     * @return void
     */
    public function testSumSingle(): void
    {
        $c1 = new Complex(1.5, 1);
        $c2 = new Complex(2.1, -2);
        $c3 = new Complex(-4, 0);

        $this->expectOutputString('-0.4 -1i');
        echo(Complex::sum($c1, $c2, $c3));
    }

    /**
     * Выполняем суммирование и сверяем вывод.
     * Используем набор данных.
     * 
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testSumMany($c1, $c2, $expected): void
    {
        $this->expectOutputString($expected);
        echo(Complex::sum($c1, $c2));
    }
    
    /**
     * Набор данных для суммирования.
     *
     * @return void
     */
    public function additionProvider()
    {
        return [
            'zero'  => [new Complex(-1, -1), new Complex(1, 1), '0'],
            'only positive symbol'  => [new Complex(-1, -1), new Complex(1, 5), '4i'],
            'only negative symbol'  => [new Complex(-1, -1), new Complex(1, -5), '-6i'],
            'positive real && negative symbol'  => [new Complex(-1, -1), new Complex(5, -5), '4 -6i'],
            'negative real && negative symbol'  => [new Complex(-1, -1), new Complex(-5, -5), '-6 -6i'],
        ];
    }
    
    /**
     * Проверяем вычитание.
     *
     * @return void
     */
    public function testDiff(): void
    {
        $this->assertEquals(new Complex(0,0), Complex::diff(new Complex(1.2, 3), new Complex(1.2, 3)), 'Вычитание провалено');
    }

    /**
     * Проверяем умножение.
     *
     * @return void
     */
    public function testMulti(): void
    {
        $this->assertEquals(new Complex(9, 3), Complex::multi(new Complex(1, -1), new Complex(3, 6)), 'Умножение провалено');
        $this->assertEquals(
            new Complex(9, 3), 
            Complex::multi(
                new Complex(1, -1), 
                new Complex(3, 6), 
                new Complex(1, 0)
            ), 
            'Умножение более чем двух множителей провалено'
        );
    }
    
    /**
     * Проверяем деление.
     *
     * @return void
     */
    public function testDiv(): void
    {
        $this->assertEquals(new Complex(1, 1), Complex::div(new Complex(13, 1), new Complex(7, -6)), 'Деление провалено');
        $this->assertEquals(new Complex(0, 1), Complex::div(new Complex(-7, -12), new Complex(-12, 7)), 'Деление 2 провалено');
    }
}