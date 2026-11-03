<?php

declare(strict_types=1);

namespace App\Tasks;

class WorkshopManager extends Worker
{
    public function calculateSalary(): float
    {
       return parent::calculateBaseSalary() + $this->baseSalary * 0.20;
    }
}