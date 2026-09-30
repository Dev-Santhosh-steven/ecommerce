<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()->wishlistItems()->with('product.primaryImage')->latest()->get()
            ->filter(fn ($i) => $i->product && $i->product->status)->values();

        return view('store.wishlist', compact('items'));
    }

    /** Heart button: add or remove. Returns the new state and count. */
    public function toggle(Request $request, Product $product)
    {
        $user = $request->user();
        $existing = WishlistItem::where('user_id', $user->id)->where('product_id', $product->id)->first();

        $existing ? $existing->delete() : WishlistItem::create(['user_id' => $user->id, 'product_id' => $product->id]);

        return response()->json([
            'saved' => ! $existing,
            'count' => $user->wishlistItems()->count(),
            'message' => $existing ? 'Removed from your wishlist' : 'Saved to your wishlist',
        ]);
    }

    /** Ids saved in the browser while signed out, merged after sign-in. */
    public function merge(Request $request)
    {
        $ids = collect($request->input('ids', []))->map(fn ($id) => (int) $id)->filter()->unique()->take(200);

        Product::whereIn('id', $ids)->pluck('id')
            ->each(fn ($id) => WishlistItem::firstOrCreate(['user_id' => $request->user()->id, 'product_id' => $id]));

        return response()->json([
            'ids' => $request->user()->wishlistItems()->pluck('product_id'),
            'count' => $request->user()->wishlistItems()->count(),
        ]);
    }

    public function destroy(Request $request, Product $product)
    {
        WishlistItem::where('user_id', $request->user()->id)->where('product_id', $product->id)->delete();

        return back()->with('toast', 'Removed from your wishlist.');
    }
}
