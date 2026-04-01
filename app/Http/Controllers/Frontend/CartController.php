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
    // HELPERS
    // ================================================================

    private function cartQuery()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id());
        }
        return CartItem::where('session_id', session()->getId());
    }

    public static function mergeSessionCart(string $sessionId = null): void
    {
        $sessionId = $sessionId ?? session()->getId();
        $userId    = Auth::id();

        \Log::info('CART::MERGE - début', [
            'session_id' => $sessionId,
            'user_id'    => $userId,
        ]);

        $items = CartItem::where('session_id', $sessionId)->get();

        \Log::info('CART::MERGE - articles trouvés', [
            'count' => $items->count(),
            'items' => $items->toArray(),
        ]);

        if ($items->isEmpty()) {
            \Log::info('CART::MERGE - rien à fusionner, fin');
            return;
        }

        $items->each(function ($item) use ($userId) {
            $existing = CartItem::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->where('color_id', $item->color_id)
                ->first();

            if ($existing) {
                \Log::info('CART::MERGE - article existant, incrément quantité', [
                    'existing_id'  => $existing->id,
                    'add_quantity' => $item->quantity,
                ]);
                $existing->increment('quantity', $item->quantity);
                $item->delete();
            } else {
                \Log::info('CART::MERGE - transfert session → user', [
                    'item_id'    => $item->id,
                    'product_id' => $item->product_id,
                    'user_id'    => $userId,
                ]);
                $item->update(['user_id' => $userId, 'session_id' => null]);
            }
        });

        \Log::info('CART::MERGE - terminé', [
            'total_items_user' => CartItem::where('user_id', $userId)->count(),
        ]);
    }

    // ================================================================
    // INDEX
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
    // ADD — accessible sans authentification
    // ================================================================

    public function add(Request $request)
    {
        \Log::info('CART::ADD - APPEL REÇU', [
            'is_auth'    => Auth::check(),
            'user_id'    => Auth::id(),
            'session_id' => session()->getId(),
            'product_id' => $request->product_id,
            'all_input'  => $request->all(),
        ]);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'color_id'   => 'nullable|exists:colors,id',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $colorId  = $request->color_id ?: null;
        $quantity = (int) $request->quantity;

        if ($product->stock_quantity < 1) {
            return response()->json(['message' => 'Ce produit est en rupture de stock.'], 422);
        }

        $existing = $this->cartQuery()
            ->where('product_id', $product->id)
            ->where('color_id', $colorId)
            ->first();

        if ($existing) {
            $newQty = min($existing->quantity + $quantity, $product->stock_quantity);
            $existing->update(['quantity' => $newQty]);
        } else {
            $data = [
                'product_id' => $product->id,
                'color_id'   => $colorId,
                'quantity'   => min($quantity, $product->stock_quantity),
            ];

            if (Auth::check()) {
                $data['user_id']    = Auth::id();
                $data['session_id'] = null;
            } else {
                $data['user_id']    = null;
                $data['session_id'] = session()->getId();
            }

            CartItem::create($data);
        }

        $cartCount = $this->cartQuery()->sum('quantity');

        return response()->json([
            'message'    => 'Produit ajouté au panier.',
            'cart_count' => $cartCount,
        ]);
    }

    // ================================================================
    // UPDATE
    // ================================================================

    public function update(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = $this->cartQuery()->findOrFail($request->item_id);

        $qty = min((int) $request->quantity, $item->product->stock_quantity);
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
    // REMOVE
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
    // CLEAR
    // ================================================================

    public function clear()
    {
        $this->cartQuery()->delete();
        return response()->json(['message' => 'Panier vidé.']);
    }

    // ================================================================
    // COUNT
    // ================================================================

    public function count()
    {
        return response()->json(['count' => $this->cartQuery()->sum('quantity')]);
    }

    // ================================================================
    // SIDEBAR
    // ================================================================

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

        return response()->json([
            'items' => $items,
            'total' => $cartItems->sum(fn($i) => $i->product->price * $i->quantity),
            'count' => $cartItems->sum('quantity'),
        ]);
    }
}