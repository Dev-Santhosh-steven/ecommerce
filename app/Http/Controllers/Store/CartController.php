<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishlistItem;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        $items = $cart->items();
        $saved = $cart->savedItems();
        $summary = $cart->summary($items);

        return view('store.cart', compact('items', 'saved', 'summary'));
    }

    /** Mini cart drawer data. */
    public function mini(Cart $cart)
    {
        return response()->json($this->payload($cart));
    }

    public function add(Request $request, Cart $cart, Product $product)
    {
        if (! $product->isPurchasable()) {
            return $this->respond($request, $cart, 'This product is available on request. Please enquire with our team.', 422);
        }

        $cart->add($product, max(1, (int) $request->input('quantity', 1)));

        if ($request->boolean('buy_now') && ! $request->expectsJson()) {
            return redirect()->route('cart.index');
        }

        return $this->respond($request, $cart, 'Added to your cart');
    }

    public function update(Request $request, Cart $cart, int $item)
    {
        $row = $cart->find($item) ?? abort(404);
        $cart->setQuantity($row, (int) $request->input('quantity', 1));

        return $this->respond($request, $cart, 'Cart updated');
    }

    public function remove(Request $request, Cart $cart, int $item)
    {
        ($cart->find($item) ?? abort(404))->delete();

        return $this->respond($request, $cart, 'Removed from your cart');
    }

    public function saveForLater(Request $request, Cart $cart, int $item)
    {
        ($cart->find($item) ?? abort(404))->update(['saved_for_later' => true]);

        return $this->respond($request, $cart, 'Saved for later');
    }

    public function moveToCart(Request $request, Cart $cart, int $item)
    {
        ($cart->find($item) ?? abort(404))->update(['saved_for_later' => false]);

        return $this->respond($request, $cart, 'Moved to your cart');
    }

    /** From the wishlist page: into the cart, off the wishlist. */
    public function fromWishlist(Request $request, Cart $cart, Product $product)
    {
        if (! $product->isPurchasable()) {
            return back()->with('toast', 'This product is available on request. Please enquire with our team.');
        }

        $cart->add($product);
        WishlistItem::where('user_id', $request->user()->id)->where('product_id', $product->id)->delete();

        return back()->with('toast', 'Moved to your cart');
    }

    private function respond(Request $request, Cart $cart, string $message, int $status = 200)
    {
        if ($request->expectsJson()) {
            return response()->json($this->payload($cart) + ['message' => $message], $status);
        }

        return back()->with('toast', $message);
    }

    private function payload(Cart $cart): array
    {
        $items = $cart->items();

        return [
            'count' => $cart->count(),
            'summary' => $cart->summary($items),
            'items' => $items->map(fn ($i) => [
                'id' => $i->id,
                'name' => $i->product->name,
                'url' => route('store.product', $i->product),
                'image' => $i->product->primaryImage ? asset('storage/' . $i->product->primaryImage->image) : null,
                'quantity' => $i->quantity,
                'price' => $i->product->unitPrice(),
                'mrp' => (float) $i->product->price,
                'max' => min(Cart::MAX_QTY, max(1, (int) $i->product->stock_quantity)),
            ])->values(),
        ];
    }
}
