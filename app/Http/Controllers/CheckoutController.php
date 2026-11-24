<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Sneaker;
use App\Models\SneakerSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    // Display checkout page
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->withErrors(['cart' => 'Your cart is empty.']);
        }

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

            $quantity = (int) ($item['quantity'] ?? 0);

            return [
                'key' => $key,
                'sneaker' => $sneaker,
                'size' => $size,
                'quantity' => $quantity,
                'unit_price' => (float) $sneaker->price,
                'line_total' => (float) $sneaker->price * $quantity,
            ];
        });

        if ($cartItems->count() !== count($cart)) {
            return redirect()
                ->route('cart.index')
                ->withErrors([
                    'cart' => 'Some cart items are no longer available. Please review your cart.',
                ]);
        }

        foreach ($cartItems as $item) {
            if (
                $item['quantity'] < 1 ||
                $item['quantity'] > $item['size']->stock_quantity
            ) {
                return redirect()
                    ->route('cart.index')
                    ->withErrors([
                        'cart' => 'The available stock has changed. Please update your cart.',
                    ]);
            }
        }

        $cartItems = $cartItems->values();
        $subtotal = $cartItems->sum('line_total');

        return view('checkout.index', compact(
            'cartItems',
            'subtotal'
        ));
    }


    // Place order
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'shipping_address' => 'required|string|max:1000',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
        ]);

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->withErrors(['cart' => 'Your cart is empty.']);
        }

        // Create order and order items together
        $order = DB::transaction(function () use ($cart, $data, $request) {

            $preparedItems = [];
            $totalAmount = 0;

            // Verify every sneaker and its available size
            foreach ($cart as $item) {

                $sneaker = Sneaker::whereKey($item['sneaker_id'] ?? 0)
                    ->lockForUpdate()
                    ->first();

                if (!$sneaker) {
                    throw ValidationException::withMessages([
                        'cart' => 'A sneaker in your cart is no longer available.',
                    ]);
                }

                $size = SneakerSize::where('sneaker_id', $sneaker->id)
                    ->whereKey($item['size_id'] ?? 0)
                    ->lockForUpdate()
                    ->first();

                if (!$size) {
                    throw ValidationException::withMessages([
                        'cart' => 'A selected shoe size is no longer available.',
                    ]);
                }

                $quantity = filter_var(
                    $item['quantity'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if (
                    $quantity === false ||
                    $quantity < 1 ||
                    $quantity > $size->stock_quantity
                ) {
                    throw ValidationException::withMessages([
                        'cart' => 'Insufficient stock for ' . $sneaker->name .
                            ', EU ' . $size->size . '. Please update your cart.',
                    ]);
                }

                $unitPrice = round((float) $sneaker->price, 2);

                $lineTotal = round($unitPrice * $quantity, 2);

                $totalAmount += $lineTotal;

                $preparedItems[] = [
                    'sneaker' => $sneaker,
                    'size' => $size,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ];
            }

            // Create overall Order
            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_amount' => round($totalAmount, 2),
                'status' => 'pending',

                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'phone' => $data['phone'],

                'shipping_address' => $data['shipping_address'],
                'shipping_city' => $data['shipping_city'],
                'shipping_postal_code' => $data['shipping_postal_code'],
                'shipping_country' => $data['shipping_country'],
            ]);

            // Create OrderItems and update stock
            foreach ($preparedItems as $item) {

                $order->orderItems()->create([
                    'sneaker_id' => $item['sneaker']->id,
                    'size' => $item['size']->size,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);

                // Reduce stock for the selected size
                $item['size']->decrement(
                    'stock_quantity',
                    $item['quantity']
                );

                // Update total sneaker stock
                $item['sneaker']->update([
                    'stock_quantity' => $item['sneaker']
                        ->sizes()
                        ->sum('stock_quantity'),
                ]);
            }

            return $order;
        });

        // Clear cart only after successful order creation
        $request->session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Your order #' . $order->id . ' has been placed successfully!');
    }
}
