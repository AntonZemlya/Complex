<?php

declare(strict_types=1);

namespace ComplexNumber\Test;

use ComplexNumber\ComplexNumber;
use PHPUnit\Framework\TestCase;

final class ComplexNumberTest extends TestCase
{
    public function testNewInstanceCreated(): void
    {
        self::assertEquals(new ComplexNumber(1), new ComplexNumber(1, 0));
    }

    public function testEquals(): void
    {
        $c1 = new ComplexNumber(1, 1);
        $c2 = new ComplexNumber(1, 1);
        self::assertEquals(true, $c1->equals($c2));

        $c3 = new ComplexNumber(1, 0);
        self::assertEquals(false, $c1->equals($c3));
    }

    public function testAddition(): void
    {
        $c1 = new ComplexNumber(1.5, 1);
        $c2 = new ComplexNumber(2.1, -2);
        $c3 = new ComplexNumber(-4, 0);

        self::assertEquals(new ComplexNumber(3.6, -1), ComplexNumber::add($c1, $c2));
        self::assertEquals(new ComplexNumber(-0.4, -1), ComplexNumber::add($c1, $c2, $c3));
    }

    public function testMultiplication(): void
    {
        self::assertEquals(new ComplexNumber(9, 3), ComplexNumber::multi(new ComplexNumber(1, -1), new ComplexNumber(3, 6)), 'Умножение провалено');
        self::assertEquals(
            new ComplexNumber(9, 3),
            ComplexNumber::multi(
                new ComplexNumber(1, -1),
                new ComplexNumber(3, 6),
                new ComplexNumber(1, 0)
            ),
            'Умножение более чем двух множителей провалено'
        );
    }

    public function testSubtraction(): void
    {
        self::assertEquals(new ComplexNumber(0,0), ComplexNumber::sub(new ComplexNumber(1.2, 3), new ComplexNumber(1.2, 3)), 'Вычитание провалено');
    }

    public function testDivision(): void
    {
        self::assertEquals(new ComplexNumber(1, 1), ComplexNumber::div(new ComplexNumber(13, 1), new ComplexNumber(7, -6)), 'Деление провалено');
        self::assertEquals(new ComplexNumber(0, 1), ComplexNumber::div(new ComplexNumber(-7, -12), new ComplexNumber(-12, 7)), 'Деление 2 провалено');

        $this->expectException(\InvalidArgumentException::class);
        ComplexNumber::div(new ComplexNumber(13, 1), new ComplexNumber(0));
    }

    /**
     * @dataProvider outputStringProvider
     */
    public function testOutputString($number, $expected): void
    {
        $this->expectOutputString($expected);
        echo($number);
    }

    /**
     * Набор данных для суммирования.
     *
     * @return array[]
     */
    private function outputStringProvider(): array
    {
        return [
            'zero'  => [new ComplexNumber(0), '0'],
            'only positive imaginary'  => [new ComplexNumber(5), '5'],
            'only positive imaginary with float part'  => [new ComplexNumber(5.7), '5.7'],
            'only negative imaginary'  => [new ComplexNumber(0, -6), '-6i'],
            'positive real && negative imaginary'  => [new ComplexNumber(4, -6), '4 -6i'],
            'negative real && negative imaginary'  => [new ComplexNumber(-6, -1), '-6 -1i'],
        ];
    }
}
