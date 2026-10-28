<?php
declare(strict_types=1);

namespace App\Services;

class EntityService
{
    /**
     * Розраховує кількість доступних місць у списку.
     *
     * @param array<int, array<string, mixed>> $places
     */
    public function countAccessiblePlaces(array $places): int
    {
        $count = 0;

        foreach ($places as $place) {
            if (($place['is_accessible'] ?? false) === true) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Розраховує ціну після застосування знижки.
     *
     * @throws \Exception Якщо знижка не входить у діапазон від 0 до 100.
     */
    public function applyDiscount(float $price, float $discount): float
    {
        if ($discount < 0 || $discount > 100) {
           throw new \Exception('Неприпустиме значення знижки!');
        }

        return $price - ($price * $discount / 100);
    }
}
