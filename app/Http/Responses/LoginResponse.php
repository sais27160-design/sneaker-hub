
<?php

namespace App\Http\Responses;

use App\Models\Sneaker;
use Illuminate\Support\Facades\DB;
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

            // Reopen the sneaker the customer wanted to save
            $request->session()->put(
                'selected_sneaker_id',
                $pendingSneakerId
            );

            return redirect()
                ->route('sneakers.index')
                ->with('success', 'Sneaker added to your wishlist!');
        }

        // Normal login redirection
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/sneakers');
    }
}
