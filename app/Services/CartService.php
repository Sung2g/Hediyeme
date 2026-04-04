<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Session\Store;
use Illuminate\Support\Collection;

class CartService
{
    private const CART_KEY = 'cart.items';

    public function __construct(private readonly Store $session) {}

    public function items(): Collection
    {
        $raw = collect($this->session->get(self::CART_KEY, []));
        $productIds = $raw->pluck('product_id')->all();

        if (empty($productIds)) {
            return collect();
        }

        $products = Product::query()
            ->with(['images' => fn ($q) => $q->orderBy('sort_order')])
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        return $raw
            ->map(function (array $item) use ($products): ?array {
                $product = $products->get($item['product_id']);
                if (! $product) {
                    return null;
                }

                $qty = max(1, (int) $item['quantity']);
                $lineTotal = (float) $product->price * $qty;

                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => (float) $product->price,
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                    'thumb_url' => $product->primaryImage()?->url(),
                ];
            })
            ->filter()
            ->values();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $items = collect($this->session->get(self::CART_KEY, []));
        $index = $items->search(fn (array $item): bool => (int) $item['product_id'] === $product->id);

        if ($index === false) {
            $items->push([
                'product_id' => $product->id,
                'quantity' => max(1, $quantity),
            ]);
        } else {
            $current = (int) $items[$index]['quantity'];
            $items[$index]['quantity'] = $current + max(1, $quantity);
        }

        $this->session->put(self::CART_KEY, $items->all());
    }

    public function updateQuantity(int $productId, int $quantity): void
    {
        $items = collect($this->session->get(self::CART_KEY, []))
            ->map(function (array $item) use ($productId, $quantity): array {
                if ((int) $item['product_id'] === $productId) {
                    $item['quantity'] = max(1, $quantity);
                }

                return $item;
            });

        $this->session->put(self::CART_KEY, $items->all());
    }

    public function remove(int $productId): void
    {
        $items = collect($this->session->get(self::CART_KEY, []))
            ->reject(fn (array $item): bool => (int) $item['product_id'] === $productId)
            ->values()
            ->all();

        $this->session->put(self::CART_KEY, $items);
    }

    public function clear(): void
    {
        $this->session->forget(self::CART_KEY);
    }

    public function count(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('line_total');
    }

    /**
     * Sepet satırları + (isteğe bağlı) kapıda ödeme akışındaki ürünün eklenmiş hâli — oturumu değiştirmez.
     */
    public function previewWithPending(?Product $pending, int $pendingQty): Collection
    {
        $items = $this->items()->keyBy('product_id');

        if ($pending !== null && $pending->is_active) {
            $pending->loadMissing(['images' => fn ($q) => $q->orderBy('sort_order')]);
            $qty = max(1, $pendingQty);
            if ($items->has($pending->id)) {
                $row = $items->get($pending->id);
                $qty = (int) $row['quantity'] + $pendingQty;
            }
            $price = (float) $pending->price;
            $items->put($pending->id, [
                'product_id' => $pending->id,
                'name' => $pending->name,
                'slug' => $pending->slug,
                'price' => $price,
                'quantity' => $qty,
                'line_total' => round($price * $qty, 2),
                'thumb_url' => $pending->primaryImage()?->url(),
            ]);
        }

        return $items->values();
    }
}
