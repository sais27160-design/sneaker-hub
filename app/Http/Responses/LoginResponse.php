<?php

namespace App\Http\Responses;

use App\Models\Sneaker;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // Complete a wishlist action started before login
        $pendingSneakerId = $request->session()->pull(
            'pending_wishlist_sneaker_id'
        );

        if (
            $pendingSneakerId &&
            Sneaker::whereKey($pendingSneakerId)->exists()
        ) {
            DB::table('wishlists')->updateOrInsert(
                [
                    'user_id' => $user->id,
                    'sneaker_id' => $pendingSneakerId,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $request->session()->put(
                'selected_sneaker_id',
                $pendingSneakerId
            );

            $request->session()->flash(
                'success',
                'Sneaker added to your wishlist!'
            );
        }

        // Admin redirect
        if ($user->role === 'admin') {
            return Inertia::location(url('/admin/dashboard'));
        }

        // Normal user: open the Blade storefront
        return Inertia::location(route('sneakers.index'));
    }
}