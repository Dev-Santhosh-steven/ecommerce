<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 * The shopper's cart: rows in cart_items owned by the logged-in user, or by a guest cookie token.
 * On login the guest rows are merged into the user's cart (see merge()).
 */
class Cart
{
    public const COOKIE = 'yara_cart';

    public const MAX_QTY = 10;

    /** Rows for the current shopper, query builder. */
    public function query()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id());
        }

        return CartItem::where('guest_token', $this->guestToken());
    }

    /** Items in the cart (not saved for later), with products. */
    public function items(): Collection
    {
        return $this->query()->where('saved_for_later', false)
            ->with('product.primaryImage')->latest('id')->get()
            ->filter(fn (CartItem $i) => $i->product)->values();
    }

    public function savedItems(): Collection
    {
        return $this->query()->where('saved_for_later', true)
            ->with('product.primaryImage')->latest('updated_at')->get()
            ->filter(fn (CartItem $i) => $i->product)->values();
    }

    public function count(): int
    {
        return (int) $this->query()->where('saved_for_later', false)->sum('quantity');
    }

    public function add(Product $product, int $qty = 1): CartItem
    {
        $item = $this->query()->firstOrNew(['product_id' => $product->id]);

        if (! $item->exists) {
            Auth::check() ? $item->user_id = Auth::id() : $item->guest_token = $this->guestToken();
            $item->quantity = 0;
        }

        $item->quantity = $this->clamp($product, ($item->saved_for_later ? 0 : $item->quantity) + $qty);
        $item->saved_for_later = false;
        $item->save();

        return $item;
    }

    public function setQuantity(CartItem $item, int $qty): void
    {
        $item->update(['quantity' => $this->clamp($item->product, $qty)]);
    }

    public function find(int $id): ?CartItem
    {
        return $this->query()->with('product')->find($id);
    }

    /** Totals shown on the cart page and mini cart. */
    public function summary(Collection $items): array
    {
        $mrp = $items->sum(fn ($i) => (float) $i->product->price * $i->quantity);
        $total = $items->sum(fn ($i) => $i->lineTotal());

        return [
            'count' => $items->sum('quantity'),
            'mrp' => $mrp,
            'discount' => max(0, $mrp - $total),
            'delivery' => 0.0, // delivery is included in Yara prices
            'total' => $total,
        ];
    }

    /** Move a guest's cart into the user's cart after login / signup. */
    public function merge(?string $token, int $userId): void
    {
        if (! $token) {
            return;
        }

        CartItem::where('guest_token', $token)->with('product')->get()->each(function (CartItem $guest) use ($userId) {
            $mine = CartItem::firstOrNew(['user_id' => $userId, 'product_id' => $guest->product_id]);
            $mine->quantity = $guest->product
                ? $this->clamp($guest->product, ($mine->exists ? $mine->quantity : 0) + $guest->quantity)
                : $guest->quantity;
            $mine->saved_for_later = $mine->exists ? $mine->saved_for_later && $guest->saved_for_later : $guest->saved_for_later;
            $mine->save();
            $guest->delete();
        });
    }

    public function guestToken(): string
    {
        $token = request()->cookie(self::COOKIE);

        if (! $token || strlen($token) !== 40) {
            $token = Str::random(40);
            Cookie::queue(self::COOKIE, $token, 60 * 24 * 60); // 60 days
            request()->cookies->set(self::COOKIE, $token);
        }

        return $token;
    }

    private function clamp(Product $product, int $qty): int
    {
        return max(1, min($qty, self::MAX_QTY, max(1, (int) $product->stock_quantity)));
    }
}
