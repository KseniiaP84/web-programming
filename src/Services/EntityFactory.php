<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\User;

class EntityFactory
{
    public static function createEntity(string $type, array $data): Product|User
    {
        return match ($type) {
            'product' => new Product(
                $data['id'],
                $data['createdAt'],
                $data['name'],
                $data['price']
            ),

            'user' => new User(
                $data['id'],
                $data['createdAt'],
                $data['name'],
                $data['email']
            ),

            default => throw new \InvalidArgumentException(
                "Невідомий тип сутності: {$type}"
            ),
        };
    }
}