<?php

declare(strict_types=1);

namespace ComplexNumber;

/**
 * Класс комплексных чисел и операций над ними.
 */
class ComplexNumber
{
    /**
     * Создание комплексного числа.
     *
     * @param float $real Вещественная часть
     * @param float $imaginary Мнимая часть
     */
    public function __construct(
        public float $real,
        public float $imaginary = 0.0
    ) {
    }

    /**
     * Вывод комплексного числа.
     */
    public function __toString(): string
    {
        if (0.0 === $this->imaginary) {
            return (string)($this->real); # Вариант a (только вещественная часть, в т.ч. 0)
        }

        if (0.0 === $this->real) {
            return "{$this->imaginary}i"; # Вариант bi (только мнимая часть)
        }

        if ($this->imaginary < 0) {
            return "$this->real {$this->imaginary}i"; # Вариант (+/-)а -bi
        }

        return "$this->real + {$this->imaginary}i"; # Вариант (+/-)а + bi
    }

    public function equals(ComplexNumber $other): bool
    {
        return $this->real === $other->real && $this->imaginary === $other->imaginary;
    }

    /**
     * Сумма двух (или более) комплексных чисел.
     */
    public static function add(
        ComplexNumber $number1,
        ComplexNumber $number2,
        ComplexNumber ...$numbers
    ): ComplexNumber {
        return array_reduce(func_get_args(), static function (ComplexNumber $sum, ComplexNumber $number): ComplexNumber {
            return new ComplexNumber(
                $sum->real + $number->real,
                $sum->imaginary + $number->imaginary
            );
        }, new ComplexNumber(0, 0));
    }

    /**
     * Умножение двух (или более) комплексных чисел.
     */
    public static function multi(
        ComplexNumber $number1,
        ComplexNumber $number2,
        ComplexNumber ...$numbers
    ): ComplexNumber {
        return array_reduce(func_get_args(), static function (ComplexNumber $multi, ComplexNumber $number): ComplexNumber {
            return new ComplexNumber(
                $multi->real * $number->real - $multi->imaginary * $number->imaginary,
                $multi->imaginary * $number->real + $multi->real * $number->imaginary
            );
        }, new ComplexNumber(1, 0));
    }

    /**
     * Вычитание комплексных чисел.
     */
    public static function sub(ComplexNumber $number1, ComplexNumber $number2): ComplexNumber
    {
        return new ComplexNumber(
            $number1->real - $number2->real,
            $number1->imaginary - $number2->imaginary
        );
    }

    /**
     * Деление комплексных чисел.
     */
    public static function div(ComplexNumber $number1, ComplexNumber $number2): ComplexNumber
    {
        if ($number2->real === 0.0 && $number2->imaginary === 0.0) {
            throw new \InvalidArgumentException('Ошибка деления на 0');
        }

        return new ComplexNumber(
            ($number1->real * $number2->real + $number1->imaginary * $number2->imaginary) / (($number2->real ** 2) + ($number2->imaginary ** 2)),
            ($number1->imaginary * $number2->real - $number1->real * $number2->imaginary) / (($number2->real ** 2) + ($number2->imaginary ** 2))
        );
    }
}
