<?php

declare(strict_types=1);

namespace App\Tasks;

class Triangle
{
    public function __construct(
        private float $a,
        private float $b,
        private float $c
    ) {
        if (
            $a <= 0 || $b <= 0 || $c <= 0 ||
            $a + $b <= $c ||
            $a + $c <= $b ||
            $b + $c <= $a
        ) {
            throw new \InvalidArgumentException(
                "Такого трикутника не існує."
            );
        }
    }

    public function calculatePerimeter(): float
    {
        return $this->a + $this->b + $this->c;
    }

    public function calculateArea(): float
    {
        $p = $this->calculatePerimeter() / 2;

        return sqrt(
            $p * ($p - $this->a) *
            ($p - $this->b) *
            ($p - $this->c)
        );
    }
}