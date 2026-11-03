<?php

declare(strict_types=1);

namespace App\Models;

class Store
{
    private array $products = [];

    public function __construct(
        private int $store_id,
        private string $name
    ) {}

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function removeProduct(int $id): bool
    {
        foreach ($this->products as $key => $product) {
            if ($product->getId() === $id) {
                unset($this->products[$key]);
                return true;
            }
        }

        return false;
    }

    public function searchProduct(string $name): ?Product
    {
        foreach ($this->products as $product) {
            if (mb_strtolower($product->getName()) === mb_strtolower($name)) {
                return $product;
            }
        }

        return null;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}