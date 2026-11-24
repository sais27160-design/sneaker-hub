<?php

namespace App\Http\Controllers;

use App\Models\Sneaker;
use App\Models\SneakerSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SneakerController extends Controller
{
    
    public function index()
    {
        $sneakers = Sneaker::with(['brand', 'sizes'])->get();

        $selectedSneaker = null;
        $selectedId = session('selected_sneaker_id');

        if ($selectedId) {
            $selectedSneaker = Sneaker::with(['brand', 'sizes'])
                ->find($selectedId);

            if (!$selectedSneaker) {
                session()->forget('selected_sneaker_id');
            }
        }

        // Load the current user's wishlist for the drawer
        $wishlistItems = collect();

        if (auth()->check()) {
            $wishlistItems = DB::table('wishlists')
                ->join('sneakers', 'wishlists.sneaker_id', '=', 'sneakers.id')
                ->leftJoin('brands', 'sneakers.brand_id', '=', 'brands.id')
                ->where('wishlists.user_id', auth()->id())
                ->select(
                    'wishlists.id as wishlist_id',
                    'sneakers.id as sneaker_id',
                    'sneakers.name',
                    'sneakers.price',
                    'sneakers.image',
                    'brands.name as brand_name'
                )
                ->orderByDesc('wishlists.created_at')
                ->get();
        }

        return view('sneakers.index', compact(
            'sneakers',
            'selectedSneaker',
            'wishlistItems'
        ));
    }

    public function handleAction(Request $request)
    {
        $action = $request->input('action');

        // Open sneaker details
        if ($action === 'view') {
            $data = $request->validate([
                'sneaker_id' => 'required|integer|exists:sneakers,id',
            ]);

            session(['selected_sneaker_id' => $data['sneaker_id']]);

            return redirect()->route('sneakers.index');
        }

        // Return to the catalogue
        if ($action === 'back') {
            session()->forget('selected_sneaker_id');

            return redirect()->route('sneakers.index');
        }

        // Add sneaker to cart
        if ($action === 'add_to_cart') {
            $data = $request->validate([
                'sneaker_id' => 'required|integer|exists:sneakers,id',
                'size_id' => 'required|integer',
                'quantity' => 'sometimes|integer|min:1',
            ]);

            $sneaker = Sneaker::findOrFail($data['sneaker_id']);

            $size = SneakerSize::where('sneaker_id', $sneaker->id)
                ->whereKey($data['size_id'])
                ->firstOrFail();

            $cart = session('cart', []);

            $key = $sneaker->id . '_' . $size->id;

            $quantity = (int) ($data['quantity'] ?? 1);

            $currentQuantity = $cart[$key]['quantity'] ?? 0;
            $newQuantity = $currentQuantity + $quantity;

            if ($newQuantity > $size->stock_quantity) {
                return redirect()
                    ->route('sneakers.index')
                    ->withErrors([
                        'quantity' => 'Only ' . $size->stock_quantity .
                            ' pairs are available in this size.',
                    ]);
            }

            $cart[$key] = [
                'sneaker_id' => $sneaker->id,
                'size_id' => $size->id,
                'quantity' => $newQuantity,
            ];

            session(['cart' => $cart]);

            return redirect()
                ->route('sneakers.index')
                ->with('success', 'Sneaker added to your cart!');
        }

        
        // Add sneaker to wishlist
        if ($action === 'add_to_wishlist') {

            $data = $request->validate([
                'sneaker_id' => 'required|integer|exists:sneakers,id',
            ]);

            // Guest: remember the sneaker and ask them to log in
            if (!$request->user()) {
                $request->session()->put(
                    'pending_wishlist_sneaker_id',
                    $data['sneaker_id']
                );

                $request->session()->put(
                    'selected_sneaker_id',
                    $data['sneaker_id']
                );

                return redirect()->guest(route('login'));
            }

            $alreadySaved = DB::table('wishlists')
                ->where('user_id', $request->user()->id)
                ->where('sneaker_id', $data['sneaker_id'])
                ->exists();

            DB::table('wishlists')->updateOrInsert(
                [
                    'user_id' => $request->user()->id,
                    'sneaker_id' => $data['sneaker_id'],
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            return redirect()
                ->route('sneakers.index')
                ->with(
                    'success',
                    $alreadySaved
                        ? 'This sneaker is already in your wishlist.'
                        : 'Sneaker added to your wishlist!'
                );
        }

        // Remove sneaker from wishlist
        if ($action === 'remove_from_wishlist') {

            if (!$request->user()) {
                return redirect()->guest(route('login'));
            }

            $data = $request->validate([
                'sneaker_id' => 'required|integer|exists:sneakers,id',
            ]);

            DB::table('wishlists')
                ->where('user_id', $request->user()->id)
                ->where('sneaker_id', $data['sneaker_id'])
                ->delete();

            return redirect()
                ->to(route('sneakers.index') . '#wishlist-drawer')
                ->with('success', 'Sneaker removed from your wishlist.');
        }
        abort(400, 'Invalid action.');

    }    
}
