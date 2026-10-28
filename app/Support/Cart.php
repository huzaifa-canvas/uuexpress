<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Session-backed shopping cart. Stores [product_id => quantity] under the
 * "cart" session key and resolves live product data on read.
 */
class Cart
{
    private const KEY = 'cart';

    private function raw(): array
    {
        return session(self::KEY, []);
    }

    private function save(array $items): void
    {
        session([self::KEY => $items]);
    }

    public function add(int $productId, int $qty = 1): void
    {
        $items = $this->raw();
        $items[$productId] = ($items[$productId] ?? 0) + max(1, $qty);
        $this->save($items);
    }

    public function update(int $productId, int $qty): void
    {
        $items = $this->raw();
        if ($qty <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $qty;
        }
        $this->save($items);
    }

    public function remove(int $productId): void
    {
        $items = $this->raw();
        unset($items[$productId]);
        $this->save($items);
    }

    public function clear(): void
    {
        session()->forget(self::KEY);
    }

    /** @return Collection<int, array{product: Product, quantity: int, line_total: float}> */
    public function items(): Collection
    {
        $raw = $this->raw();
        if (empty($raw)) {
            return collect();
        }

        $products = Product::whereIn('id', array_keys($raw))->get()->keyBy('id');

        return collect($raw)
            ->filter(fn ($qty, $id) => $products->has($id))
            ->map(function ($qty, $id) use ($products) {
                $product = $products[$id];

                return [
                    'product' => $product,
                    'quantity' => (int) $qty,
                    'line_total' => round((float) $product->price * (int) $qty, 2),
                ];
            })
            ->values();
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }

    public function subtotal(): float
    {
        return round($this->items()->sum('line_total'), 2);
    }

    public function isEmpty(): bool
    {
        return empty($this->raw());
    }
}
