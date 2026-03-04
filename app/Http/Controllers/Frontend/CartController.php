<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ================================================================
    // HELPERS — identifier le panier (user connecté ou session)
    // ================================================================

    private function cartQuery()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id());
        }
        return CartItem::where('session_id', session()->getId());
    }

    private function cartOwner(): array
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id(), 'session_id' => null];
        }
        return ['user_id' => null, 'session_id' => session()->getId()];
    }

    /**
     * Fusionner le panier session → panier utilisateur après connexion.
     * À appeler dans le LoginController après authentification.
     */
    public static function mergeSessionCart(): void
    {
        $sessionId = session()->getId();
        $userId    = Auth::id();

        CartItem::where('session_id', $sessionId)->each(function ($item) use ($userId) {
            $existing = CartItem::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->where('color_id', $item->color_id)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item->quantity);
                $item->delete();
            } else {
                $item->update(['user_id' => $userId, 'session_id' => null]);
            }
        });
    }

    // ================================================================
    // INDEX — page panier
    // ================================================================

    public function index()
    {
        $cartItems = $this->cartQuery()
            ->with(['product.images', 'color'])
            ->get();

        $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

        return view('frontend.cart', compact('cartItems', 'subtotal'));
    }

    // ================================================================
    // ADD — ajouter un produit
    // ================================================================

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'color_id'   => 'nullable|exists:colors,id',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $colorId  = $request->color_id ?: null;
        $quantity = (int) $request->quantity;

        // Vérification stock
        if ($product->stock_quantity < 1) {
            return response()->json(['message' => 'Ce produit est en rupture de stock.'], 422);
        }

        // Chercher un article existant dans le panier
        $existing = $this->cartQuery()
            ->where('product_id', $product->id)
            ->where('color_id', $colorId)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;

            // Ne pas dépasser le stock disponible
            if ($newQty > $product->stock_quantity) {
                $newQty = $product->stock_quantity;
            }

            $existing->update(['quantity' => $newQty]);
        } else {
            CartItem::create(array_merge($this->cartOwner(), [
                'product_id' => $product->id,
                'color_id'   => $colorId,
                'quantity'   => min($quantity, $product->stock_quantity),
            ]));
        }

        $cartCount = $this->cartQuery()->sum('quantity');

        return response()->json([
            'message'    => 'Produit ajouté au panier.',
            'cart_count' => $cartCount,
        ]);
    }

    // ================================================================
    // UPDATE — modifier la quantité
    // ================================================================

    public function update(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = $this->cartQuery()->findOrFail($request->item_id);

        // Vérification stock
        $max = $item->product->stock_quantity;
        $qty = min((int) $request->quantity, $max);
        $item->update(['quantity' => $qty]);

        $subtotal  = $this->cartQuery()->with('product')->get()
            ->sum(fn($i) => $i->product->price * $i->quantity);
        $lineTotal = $item->product->price * $qty;
        $cartCount = $this->cartQuery()->sum('quantity');

        return response()->json([
            'message'    => 'Panier mis à jour.',
            'line_total' => number_format($lineTotal, 0, ',', ' '),
            'subtotal'   => number_format($subtotal, 0, ',', ' '),
            'cart_count' => $cartCount,
        ]);
    }

    // ================================================================
    // REMOVE — supprimer un article
    // ================================================================

    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
        ]);

        $item = $this->cartQuery()->findOrFail($request->item_id);
        $item->delete();

        $subtotal  = $this->cartQuery()->with('product')->get()
            ->sum(fn($i) => $i->product->price * $i->quantity);
        $cartCount = $this->cartQuery()->sum('quantity');

        return response()->json([
            'message'    => 'Article supprimé.',
            'subtotal'   => number_format($subtotal, 0, ',', ' '),
            'cart_count' => $cartCount,
        ]);
    }

    // ================================================================
    // CLEAR — vider le panier
    // ================================================================

    public function clear()
    {
        $this->cartQuery()->delete();

        return response()->json(['message' => 'Panier vidé.']);
    }

    // ================================================================
    // COUNT — pour le badge header (endpoint AJAX optionnel)
    // ================================================================

    public function count()
    {
        return response()->json(['count' => $this->cartQuery()->sum('quantity')]);
    }

    
/**
 * Endpoint AJAX pour le sidebar panier du header.
 * Route : GET /client/cart/sidebar
 */
public function sidebar()
{
    $cartItems = $this->cartQuery()
        ->with(['product.images', 'color'])
        ->get();

    $items = $cartItems->map(function ($item) {
        return [
            'id'         => $item->id,
            'product_id' => $item->product_id,
            'name'       => $item->product->name,
            'price'      => $item->product->price,
            'quantity'   => $item->quantity,
            'image'      => $item->product->images->first()?->image_path ?? null,
            'color'      => $item->color ? [
                'name' => $item->color->name,
                'code' => $item->color->code,
            ] : null,
        ];
    });

    $total = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
    $count = $cartItems->sum('quantity');

    return response()->json([
        'items' => $items,
        'total' => $total,
        'count' => $count,
    ]);
}
}