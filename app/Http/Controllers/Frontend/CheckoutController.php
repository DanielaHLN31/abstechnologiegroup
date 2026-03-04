<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{

    // ================================================================
    // STEP 1 — Page checkout (formulaire livraison + résumé panier)
    // ================================================================

    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product.images', 'color'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart')
                ->with('error', 'Votre panier est vide.');
        }

        // Vérifier que tous les produits sont encore en stock
        $stockErrors = [];
        foreach ($cartItems as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                $stockErrors[] = "« {$item->product->name} » : stock insuffisant ({$item->product->stock_quantity} disponible(s)).";
            }
        }

        $subtotal      = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $shippingCost  = $subtotal >= 1000000 ? 0 : 1000; // livraison gratuite au-dessus de 1M FCFA
        $total         = $subtotal + $shippingCost;

        // Pré-remplir avec les infos du compte
        $user = Auth::user();
        $prefill = [
            'fullname' => $user->name,
            'email'    => $user->email,
            'phone'    => $user->client->phone ?? '',
            'address'  => $user->client->address ?? '',
            'city'     => $user->client->city ?? '',
            'country'  => $user->client->country ?? 'Bénin',
        ];

        return view('frontend.checkout', compact(
            'cartItems', 'subtotal', 'shippingCost', 'total', 'prefill', 'stockErrors'
        ));
    }

    // ================================================================
    // STEP 2 — Traitement de la commande
    // ================================================================
    public function store(Request $request)
    {
        Log::info('Début checkout', [
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'ajax' => $request->has('ajax') ? 'oui' : 'non'
        ]);

        $request->validate([
            'fullname'       => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:30',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'country'        => 'required|string|max:100',
            'notes'          => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cash_on_delivery,mobile_money,bank_transfer,mtn_benin,moov_benin,celtiis_bj',
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())
            ->with(['product.images', 'color'])
            ->get();

        if ($cartItems->isEmpty()) {
            if ($request->has('ajax')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Votre panier est vide.'
                ], 422);
            }
            return redirect()->route('client.cart')->with('error', 'Votre panier est vide.');
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                if ($request->has('ajax')) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock insuffisant pour « {$item->product->name} »."
                    ], 422);
                }
                return back()->with('error', "Stock insuffisant pour « {$item->product->name} ».");
            }
        }

        $subtotal     = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $shippingCost = $subtotal >= 1000000 ? 0 : 1000;
        $total        = $subtotal + $shippingCost;

        try {
            $order = DB::transaction(function () use ($request, $cartItems, $subtotal, $shippingCost, $total) {
                $order = Order::create([
                    'order_number'     => Order::generateOrderNumber(),
                    'user_id'          => Auth::id(),
                    'shipping_fullname'=> $request->fullname,
                    'shipping_email'   => $request->email,
                    'shipping_phone'   => $request->phone,
                    'shipping_address' => $request->address,
                    'shipping_city'    => $request->city,
                    'shipping_country' => $request->country,
                    'shipping_notes'   => $request->notes,
                    'subtotal'         => $subtotal,
                    'shipping_cost'    => $shippingCost,
                    'total'            => $total,
                    'status'           => 'pending',
                    'payment_method'   => in_array($request->payment_method, ['mtn_benin','moov_benin','celtiis_bj']) ? 'mobile_money' : $request->payment_method,
                    'payment_status'   => 'unpaid',
                ]);

                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id'      => $order->id,
                        'product_id'    => $item->product_id,
                        'color_id'      => $item->color_id,
                        'product_name'  => $item->product->name,
                        'color_name'    => $item->color?->name,
                        'product_image' => $item->product->images->first()?->image_path,
                        'quantity'      => $item->quantity,
                        'unit_price'    => $item->product->price,
                        'total_price'   => $item->product->price * $item->quantity,
                    ]);

                    $item->product->decrement('stock_quantity', $item->quantity);
                }

                CartItem::where('user_id', Auth::id())->delete();

                return $order;
            });

            // ✅ RÉPONSE JSON POUR AJAX
            if ($request->has('ajax')) {
                return response()->json([
                    'success'      => true,
                    'order_number' => $order->order_number,
                    'message'      => 'Commande créée avec succès.'
                ]);
            }

            // ✅ RÉPONSE NORMALE POUR NON-AJAX
            return redirect()->route('client.order.confirmation', $order->order_number)
                ->with('success', 'Votre commande a été passée avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors du checkout', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->has('ajax')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la création de la commande.'
                ], 500);
            }

            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    // ================================================================
    // STEP 3 — Page de confirmation
    // ================================================================

    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        return view('frontend.order-confirmation', compact('order'));
    }

    // ================================================================
    // MES COMMANDES — liste
    // ================================================================

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('frontend.my-orders', compact('orders'));
    }

    // ================================================================
    // DÉTAIL COMMANDE
    // ================================================================

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        return view('frontend.order-detail', compact('order'));
    }

    // ================================================================
    // ANNULER UNE COMMANDE (seulement si pending ou confirmed)
    // ================================================================

    public function cancel(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Cette commande ne peut plus être annulée.');
        }

        DB::transaction(function () use ($order) {
            // Remettre le stock
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)
                        ->increment('stock_quantity', $item->quantity);
                    Product::where('id', $item->product_id)
                        ->update(['in_stock' => true]);
                }
            }
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Votre commande a été annulée.');
    }
}