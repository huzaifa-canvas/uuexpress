<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        return view('pages.cart', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
        ]);
    }

    public function add(Request $request, Product $product, Cart $cart)
    {
        abort_unless($product->is_active, 404);

        $qty = max(1, (int) $request->input('quantity', 1));
        $cart->add($product->id, $qty);

        return redirect()->route('cart')->with('status', html_entity_decode($product->name) . ' added to your cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        $quantities = $request->input('quantities', []);
        foreach ($quantities as $productId => $qty) {
            $cart->update((int) $productId, (int) $qty);
        }

        return redirect()->route('cart')->with('status', 'Cart updated.');
    }

    public function remove(Product $product, Cart $cart)
    {
        $cart->remove($product->id);

        return redirect()->route('cart')->with('status', 'Item removed.');
    }
}
