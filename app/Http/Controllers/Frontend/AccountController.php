<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Wishlist;
// ← plus de "use App\Models\Address"

class AccountController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $client = $user->client;

        $ordersCount   = Order::where('user_id', $user->id)->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $totalSpent    = Order::where('user_id', $user->id)
                              ->whereIn('status', ['delivered', 'shipped'])
                              ->sum('total');

        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $orders       = Order::where('user_id', $user->id)->withCount('items')->latest()->get();
        $wishlistItems = Wishlist::where('user_id', $user->id)->with(['product.images'])->get();

        return view('frontend.account', compact(
            'ordersCount', 'wishlistCount', 'totalSpent',
            'recentOrders', 'orders', 'wishlistItems', 'client'
        ));
    }

    public function update(Request $request)
    {
        $user   = auth()->user();
        $client = $user->client;

        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:100',
            'country'    => 'nullable|string|max:100',
            'avatar'     => 'nullable|image|max:2048',
        ]);

        $userData = $request->only(['email']);
        if ($request->filled('first_name') || $request->filled('last_name')) {
            $userData['name'] = trim($request->first_name . ' ' . $request->last_name);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $user->update($userData);

        if ($client) {
            $client->update($request->only(['phone', 'address', 'city', 'country']));
        }

        return redirect()->back()
                         ->with('success', 'Profil mis à jour avec succès.')
                         ->with('section', 'profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Mot de passe actuel incorrect.'])
                ->with('section', 'password');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()
                         ->with('success', 'Mot de passe mis à jour.')
                         ->with('section', 'password');
    }
}