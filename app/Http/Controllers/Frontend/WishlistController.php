<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ================================================================
    // INDEX — page wishlist
    // ================================================================

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with(['product.images', 'product.brand', 'product.category', 'product.colors'])
            ->latest()
            ->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    // ================================================================
    // ADD — ajouter aux favoris (AJAX)
    // ================================================================

    public function add(Request $request)
    {
        // Sécurité : utilisateur non connecté → réponse JSON avec redirect
        if (!Auth::check()) {
            return response()->json([
                'redirect' => route('client.login'),
                'message'  => 'Veuillez vous connecter pour ajouter aux favoris.',
            ], 401);
        }

        $request->validate(['product_id' => 'required|exists:products,id']);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Ce produit est déjà dans vos favoris.',
                'status'  => 'already',
                'count'   => Wishlist::where('user_id', Auth::id())->count(),
            ]);
        }

        Wishlist::create([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'message' => 'Produit ajouté à vos favoris.',
            'status'  => 'added',
            'count'   => $count,
        ]);
    }

    // ================================================================
    // REMOVE — retirer des favoris (AJAX)
    // ================================================================

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'redirect' => route('client.login'),
                'message'  => 'Non authentifié.',
            ], 401);
        }

        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'message' => 'Produit retiré de vos favoris.',
            'status'  => 'removed',
            'count'   => $count,
        ]);
    }

    // ================================================================
    // TOGGLE — ajouter ou retirer (bouton cœur, pratique)
    // ================================================================

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'redirect' => route('client.login'),
                'message'  => 'Veuillez vous connecter.',
            ], 401);
        }

        $request->validate(['product_id' => 'required|exists:products,id']);

        $item = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->delete();
            $status = 'removed';
            $message = 'Retiré de vos favoris.';
        } else {
            Wishlist::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
            ]);
            $status = 'added';
            $message = 'Ajouté à vos favoris.';
        }

        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'message' => $message,
            'status'  => $status,
            'count'   => $count,
        ]);
    }

    // ================================================================
    // IDS — retourner les IDs des produits en wishlist (pour colorer
    //        les cœurs déjà actifs au chargement de la page)
    // ================================================================

    public function ids()
    {
        if (!Auth::check()) {
            return response()->json(['ids' => []]);
        }

        $ids = Wishlist::where('user_id', Auth::id())->pluck('product_id');

        return response()->json(['ids' => $ids]);
    }
}