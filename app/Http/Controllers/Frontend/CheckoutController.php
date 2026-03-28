<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    // ================================================================
    // STEP 1 — Page checkout
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

        $stockErrors = [];
        foreach ($cartItems as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                $stockErrors[] = "« {$item->product->name} » : stock insuffisant ({$item->product->stock_quantity} disponible(s)).";
            }
        }

        $subtotal     = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $shippingCost = 0;
        $total        = $subtotal;

        $user    = Auth::user();
        $prefill = [
            'fullname' => $user->name,
            'email'    => $user->email,
            'phone'    => $user->client->phone   ?? '',
            'address'  => $user->client->address ?? '',
            'city'     => $user->client->city    ?? '',
            'country'  => $user->client->country ?? 'Bénin',
        ];

        return view('frontend.checkout', compact(
            'cartItems', 'subtotal', 'shippingCost', 'total', 'prefill', 'stockErrors'
        ));
    }

    // ================================================================
    // Initialiser FedaPay via config() (compatible config:cache)
    // ================================================================
    private function bootFedaPay(): void
    {
        \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('services.fedapay.env', 'sandbox'));
    }

    // ================================================================
    // Formater le numéro de téléphone pour FedaPay (Bénin)
    //
    // Règle : FedaPay attend +22901XXXXXXXX (nouveau format Bénin)
    // On garde UNIQUEMENT les chiffres après avoir retiré tout indicatif,
    // puis on préfixe avec +229.
    // ================================================================
    private function formatPhone(string $raw): string
    {
        // 1. Garder uniquement les chiffres
        $digits = preg_replace('/\D/', '', $raw);

        // 2. Retirer tous les indicatifs connus au début
        //    +229  → 229XXXXXXXX  (ancien format Bénin 8 chiffres)
        //    +22901→ 22901XXXXXXXX (nouveau format Bénin 10 chiffres)
        //    Tout autre indicatif international (+33, +1, etc.)
        if (str_starts_with($digits, '22901') && strlen($digits) === 13) {
            // Déjà au nouveau format béninois complet → garder tel quel
            $local = $digits;
        } elseif (str_starts_with($digits, '229') && strlen($digits) === 11) {
            // Ancien format béninois (229 + 8 chiffres) → garder tel quel
            $local = $digits;
        } elseif (strlen($digits) === 10 && str_starts_with($digits, '01')) {
            // 01XXXXXXXX (nouveau format local sans indicatif) → ajouter 229
            $local = '229' . $digits;
        } elseif (strlen($digits) === 8) {
            // 8 chiffres locaux (ancien format sans indicatif) → ajouter 229
            $local = '229' . $digits;
        } else {
            // Numéro étranger ou format inconnu → on garde les chiffres bruts
            // FedaPay rejettera si invalide, mais on n'écrase pas un numéro étranger
            $local = $digits;
        }

        return '+' . $local;
    }

    // ================================================================
    // STEP 2 — Création commande + initiation paiement FedaPay
    // ================================================================
    public function store(Request $request)
    {
        Log::info('Début checkout', ['user_id' => Auth::id()]);

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
            return response()->json(['success' => false, 'message' => 'Votre panier est vide.'], 422);
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuffisant pour « {$item->product->name} ».",
                ], 422);
            }
        }

        $subtotal      = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $total         = $subtotal;
        $mobileMethods = ['mobile_money', 'mtn_benin', 'moov_benin', 'celtiis_bj'];
        $needsFedaPay  = in_array($request->payment_method, $mobileMethods);

        // ── Créer la commande en BDD ──────────────────────────────────────
        try {
            $order = DB::transaction(function () use ($request, $cartItems, $subtotal, $total) {

                $paymentMethodNormalized = in_array(
                    $request->payment_method,
                    ['mtn_benin', 'moov_benin', 'celtiis_bj']
                ) ? 'mobile_money' : $request->payment_method;

                $order = Order::create([
                    'order_number'      => Order::generateOrderNumber(),
                    'user_id'           => Auth::id(),
                    'shipping_fullname' => $request->fullname,
                    'shipping_email'    => $request->email,
                    'shipping_phone'    => $request->phone,
                    'shipping_address'  => $request->address,
                    'shipping_city'     => $request->city,
                    'shipping_country'  => $request->country,
                    'shipping_notes'    => $request->notes,
                    'subtotal'          => $subtotal,
                    'shipping_cost'     => 0,
                    'total'             => $total,
                    'status'            => 'pending',
                    'payment_method'    => $paymentMethodNormalized,
                    'payment_status'    => 'unpaid',
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

        } catch (\Exception $e) {
            Log::error('Erreur création commande', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de la commande.',
            ], 500);
        }

        // ── Paiement à la livraison / virement → confirmation directe ─────
        if (!$needsFedaPay) {
            return response()->json([
                'success'      => true,
                'redirect_url' => route('client.order.confirmation', $order->order_number),
            ]);
        }

        // ── Mobile Money → générer le token FedaPay ───────────────────────
        $this->bootFedaPay();

        try {
            session(['order_checkout' => ['order_number' => $order->order_number]]);

            $phone = $this->formatPhone($request->phone);

            $nameParts = explode(' ', trim($request->fullname), 2);
            $firstName = $nameParts[0];
            $lastName  = $nameParts[1] ?? '';

            $transactionPayload = [
                'description'        => 'Commande ' . $order->order_number . ' — ' . config('app.name'),
                'amount'             => (int) $total,
                'currency'           => ['iso' => 'XOF'],
                'callback_url'       => route('payment.callback'),
                'merchant_reference' => $order->order_number,
                'customer'           => [
                    'firstname'    => $firstName,
                    'lastname'     => $lastName,
                    'email'        => $request->email,
                    'phone_number' => [
                        'number'  => $phone,
                        'country' => 'bj',
                    ],
                ],
            ];

            Log::info('FedaPay Transaction::create payload', $transactionPayload);

            $transaction = \FedaPay\Transaction::create($transactionPayload);
            $token       = $transaction->generateToken();

            Log::info('Token FedaPay généré', [
                'transaction_id' => $transaction->id,
                'order_number'   => $order->order_number,
            ]);

            return response()->json([
                'success'      => true,
                'checkout_url' => $token->url,
            ]);

        } catch (\Exception $e) {
            $httpBody   = method_exists($e, 'getHttpBody')   ? $e->getHttpBody()   : 'n/a';
            $httpStatus = method_exists($e, 'getHttpStatus') ? $e->getHttpStatus() : 'n/a';
            $jsonBody   = method_exists($e, 'getJsonBody')   ? $e->getJsonBody()   : [];

            Log::error('FedaPay Error', [
                'class'       => get_class($e),
                'message'     => $e->getMessage(),
                'http_status' => $httpStatus,
                'http_body'   => $httpBody,
                'json_body'   => $jsonBody,
                'order'       => $order->order_number,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Commande enregistrée (n° ' . $order->order_number . '), mais le paiement n\'a pas pu être initié. Contactez-nous.',
            ], 500);
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

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')->latest()->paginate(10);
        return view('frontend.my-orders', compact('orders'));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())->with('items')->firstOrFail();
        return view('frontend.order-detail', compact('order'));
    }

    public function cancel(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())->firstOrFail();

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Cette commande ne peut plus être annulée.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)->increment('stock_quantity', $item->quantity);
                    Product::where('id', $item->product_id)->update(['in_stock' => true]);
                }
            }
            $order->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Votre commande a été annulée.');
    }
}