<?php

namespace App\Http\Controllers;

use App\Models\Sneaker;
use App\Models\SneakerSize;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Display cart items
    public function index()
    {
        $cart = session('cart', []);

        $cartItems = collect($cart)->map(function ($item, $key) {

            $sneaker = Sneaker::with('brand')
                ->find($item['sneaker_id'] ?? 0);

            if (!$sneaker) {
                return null;
            }

            $size = SneakerSize::where('sneaker_id', $sneaker->id)
                ->whereKey($item['size_id'] ?? 0)
                ->first();

            if (!$size) {
                return null;
            }

            $quantity = (int) ($item['quantity'] ?? 1);
            $price = (float) $sneaker->price;

            return [
                'key' => $key,
                'sneaker' => $sneaker,
                'size' => $size,
                'quantity' => $quantity,
                'unit_price' => $price,
                'line_total' => $price * $quantity,
            ];
        })->filter()->values();

        $subtotal = $cartItems->sum('line_total');

        return view('cart.index', compact(
            'cartItems',
            'subtotal'
        ));
    }

    // Update item quantity
    public function update(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        $key = $data['key'];

        if (!isset($cart[$key])) {
            return back()->withErrors([
                'cart' => 'Cart item not found.',
            ]);
        }

        $item = $cart[$key];

        $size = SneakerSize::where('sneaker_id', $item['sneaker_id'])
            ->whereKey($item['size_id'])
            ->first();

        if (!$size) {
            return back()->withErrors([
                'cart' => 'This shoe size is no longer available.',
            ]);
        }

        if ($data['quantity'] > $size->stock_quantity) {
            return back()->withErrors([
                'quantity' => 'Only ' . $size->stock_quantity .
                    ' pairs are available in this size.',
            ]);
        }

        $cart[$key]['quantity'] = $data['quantity'];

        session(['cart' => $cart]);

        return back()->with('success', 'Cart quantity updated.');
    }

    // Remove item from cart
    public function remove(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session('cart', []);

        unset($cart[$data['key']]);

        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart.');
    }
}
