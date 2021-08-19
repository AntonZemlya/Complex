<?php

/**
 * Класс операций с комплексными числами.
 * 
 * @author A. Zemlyanukhin <anton.zemlya@gmail.com>
 */
class Complex {

    private float $real;
    private float $symbol;

    /**
     * Создание комплексного числа.
     * 
     * @param float $real вещественная часть
     * @param float $symbol мнимая часть
     */
    public function __construct(float $real, float $symbol)
    {
        $this->setReal($real)
            ->setSymbol($symbol);
    }
    
    /**
     * Суммирует два (или более) комлексных числа.
     *
     * @param  mixed $c1
     * @param  mixed $c2
     * @param  mixed $cNums
     * @return Complex
     */
    public static function sum(Complex $c1, Complex $c2, Complex ...$cNums): Complex
    {
        $sum = new Complex(0,0);
        foreach(func_get_args() as $cNum){
            $sum->setReal($sum->getReal() + $cNum->getReal())
                ->setSymbol($sum->getSymbol() + $cNum->getSymbol());
        }
        return $sum;
    }
    
    /**
     * Вычитает два комплексных числа.
     *
     * @param  mixed $c1 уменьшаемое
     * @param  mixed $c2 вычитаемое
     * @return Complex
     */
    public static function diff(Complex $c1, Complex $c2): Complex
    {
        return new Complex($c1->getReal() - $c2->getReal(), $c1->getSymbol() - $c2->getSymbol());
    }
    
    /**
     * Умножение двух (или более) комплексных чисел.
     *
     * @param  mixed $c1 первый множитель
     * @param  mixed $c2 второй множитель
     * @param  mixed $cNums прочие множители
     * @return Complex
     */
    public static function multi(Complex $c1, Complex $c2, Complex ...$cNums): Complex
    {
        $multi = new Complex(
            $c1->getReal() * $c2->getReal() - $c1->getSymbol() * $c2->getSymbol(),
            $c1->getSymbol() * $c2->getReal() + $c1->getReal() * $c2->getSymbol()
        );
        foreach($cNums as $cNum){
            $multi->setReal(
                $multi->getReal() * $cNum->getReal() - $multi->getSymbol() * $cNum->getSymbol()
            )->setSymbol(
                $multi->getSymbol() * $cNum->getReal() + $multi->getReal() * $cNum->getSymbol()
            );
        }
        return $multi;
    }

    /**
     * Деление комплексных чисел.
     *
     * @param  mixed $c1 числитель
     * @param  mixed $c2 знаменатель
     * @return Complex
     */
    public static function div(Complex $c1, Complex $c2): Complex
    {
        return new Complex(
            ($c1->getReal() * $c2->getReal() + $c1->getSymbol() * $c2->getSymbol()) / (pow($c2->getReal(), 2) + pow($c2->getSymbol(), 2)), 
            ($c1->getSymbol() * $c2->getReal() - $c1->getReal() * $c2->getSymbol()) / (pow($c2->getReal(), 2) + pow($c2->getSymbol(), 2))
        );
    }
	
	/**
	 * Вывод комплексного числа.
     * 
	 * @return void
	 */
	public function __toString()
	{
        if (0 == $this->symbol) { 
            // вариант a (только вещественная часть, в т.ч. 0)
            return "{$this->real}";
        } else if (0 == $this->real) {
            // вариант bi (только мнимая часть)
            return "{$this->symbol}i";
        } else if ($this->symbol < 0) {
            // вариант (+/-)а -bi
            return "$this->real {$this->symbol}i"; 
        } else {
            // вариант (+/-)а + bi
            return "$this->real + {$this->symbol}i";
        }
	}

    // Геттеры и сеттеры

    /**
     * Get the value of real
     */ 
    public function getReal()
    {
        return $this->real;
    }

    /**
     * Set the value of real
     *
     * @return  self
     */ 
    public function setReal($real)
    {
        $this->real = $real;

        return $this;
    }

    /**
     * Get the value of symbol
     */ 
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set the value of symbol
     *
     * @return  self
     */ 
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }
} 