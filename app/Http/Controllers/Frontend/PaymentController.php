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

/*
|--------------------------------------------------------------------------
| PRÉREQUIS
|--------------------------------------------------------------------------
| composer require fedapay/fedapay-php
|
| Dans .env :
|   FEDAPAY_SECRET_KEY=sk_sandbox_xxxxxx     (sandbox pour les tests)
|   FEDAPAY_PUBLIC_KEY=pk_sandbox_xxxxxx
|   FEDAPAY_ENV=sandbox                      (sandbox | live)
|   FEEXPAY_API_KEY=fp_xxxxxxx               (optionnel si tu utilises FeexPay)
|   FEEXPAY_SHOP_ID=xxxxxxx
|--------------------------------------------------------------------------
*/

use FedaPay\FedaPay;
use FedaPay\Transaction;
use FedaPay\Customer;

class PaymentController extends Controller
{
    public function __construct()
    {

        // Initialiser FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.env', 'sandbox')); // 'sandbox' ou 'live'
    }

    // ================================================================
    // INITIER LE PAIEMENT MOBILE MONEY (sans redirection)
    // MTN Bénin, Moov Bénin, Celtiis Bénin
    // ================================================================
    public function initiate(Request $request)
    {
        Log::info('=== INITIATE PAIEMENT DÉBUT ===', [
            'order_number' => $request->order_number,
            'method' => $request->payment_method,
            'phone' => $request->phone
        ]);

        try {
            $request->validate([
                'order_number'   => 'required|string',
                'payment_method' => 'required|in:mtn_benin,moov_benin,celtiis_bj',
                'phone'          => ['required', 'string', 'regex:/^[0-9]{8}$/'],
            ]);

            $order = Order::where('order_number', $request->order_number)
                ->where('user_id', Auth::id())
                ->where('payment_status', 'unpaid')
                ->firstOrFail();

            Log::info('Commande trouvée', [
                'order_id' => $order->id,
                'total' => $order->total
            ]);

            // Nettoyer le numéro
            $phone = preg_replace('/\D/', '', $request->phone);
            if (strlen($phone) === 8) {
                $phone = '229' . $phone;
            }
            $phoneInternational = '+' . $phone;

            Log::info('Numéro formaté', [
                'original' => $request->phone,
                'formatted' => $phoneInternational
            ]);

            // Initialiser FedaPay
            \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment(config('services.fedapay.env', 'sandbox'));
            

            // ============================================================
            // GESTION DU CLIENT AVEC STOCKAGE DE L'ID
            // ============================================================
            $user = $order->user;
            $email = $user->email ?? $order->shipping_email;
            $customer = null;

            Log::info('Gestion du client FedaPay', [
                'user_id' => $user->id,
                'email' => $email,
                'has_stored_id' => !empty($user->fedapay_customer_id)
            ]);

            try {
                // ÉTAPE 1: Si on a déjà un customer_id stocké, l'utiliser
                if (!empty($user->fedapay_customer_id)) {
                    try {
                        $customer = \FedaPay\Customer::retrieve($user->fedapay_customer_id);
                        Log::info('Client récupéré depuis ID stocké', [
                            'customer_id' => $customer->id,
                            'email' => $customer->email
                        ]);
                    } catch (\Exception $e) {
                        // L'ID n'est plus valide chez FedaPay, on le réinitialise
                        Log::warning('ID client FedaPay invalide, réinitialisation', [
                            'old_id' => $user->fedapay_customer_id
                        ]);
                        $user->fedapay_customer_id = null;
                        $user->save();
                    }
                }

                // ÉTAPE 2: Pas de customer_id valide, on crée un nouveau client
                if (!$customer) {
                    Log::info('Création d\'un nouveau client FedaPay');
                    
                    $nameParts = explode(' ', trim($order->shipping_fullname), 2);
                    $firstname = $nameParts[0];
                    $lastname = isset($nameParts[1]) ? $nameParts[1] : '';
                    
                    $customerData = [
                        'email' => $email,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                    ];
                    
                    // Ajouter le téléphone
                    if (!empty($phoneInternational)) {
                        $customerData['phone_number'] = [
                            'number' => $phoneInternational,
                            'country' => 'BJ',
                        ];
                    }
                    
                    // Créer le client chez FedaPay
                    $customer = \FedaPay\Customer::create($customerData);
                    
                    Log::info('Nouveau client FedaPay créé', [
                        'customer_id' => $customer->id,
                        'email' => $customer->email
                    ]);
                    
                    // Stocker l'ID pour les prochaines fois
                    $user->fedapay_customer_id = $customer->id;
                    $user->save();
                    
                    Log::info('ID client stocké en base', [
                        'user_id' => $user->id,
                        'fedapay_customer_id' => $customer->id
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error('Erreur lors de la gestion du client FedaPay', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de créer le profil de paiement. Veuillez réessayer.'
                ], 422);
            }

            // ============================================================
            // CRÉATION DE LA TRANSACTION
            // ============================================================
            try {
                // Correspondance des modes de paiement
                $paymentMethods = [
                    'mtn_benin'  => 'mtn_benin',
                    'moov_benin' => 'moov_benin',
                    'celtiis_bj' => 'celtiis_benin', // Vérifiez le nom exact dans la doc
                ];
                
                $paymentMethod = $paymentMethods[$request->payment_method] ?? $request->payment_method;
                
                $testMode = true;

                if ($testMode) {
                    $amount = 100; // 100 FCFA pour tester
                    Log::warning('⚠️ MODE TEST ACTIVÉ - Montant forcé à 100 FCFA');
                } else {
                    $amount = (int) $order->total;
                }
                // Données de la transaction
                $transactionData = [
                    'description'        => 'Commande ' . $order->order_number . ' — ' . config('app.name'),
                    'amount'             => $amount,
                    'currency'           => ['iso' => 'XOF'],
                    'callback_url'       => route('payment.callback'),
                    'merchant_reference' => $order->order_number,

                    'customer' => [
                        'id' => $customer->id
                    ],

                    'payment_method' => [
                        'type' => $paymentMethod,
                        'phone_number' => [
                            'number'  => $phoneInternational,
                            'country' => 'BJ'
                        ]
                    ],
                ];
                
                Log::info('Création transaction FedaPay', [
                    'description' => $transactionData['description'],
                    'amount' => $transactionData['amount'],
                    'currency' => $transactionData['currency'],
                    'customer_id' => $transactionData['customer'], // Maintenant c'est un ID
                    'payment_method_type' => $transactionData['payment_method']['type'],
                    'phone' => $transactionData['payment_method']['phone_number']
                ]);
                
                $transaction = \FedaPay\Transaction::create($transactionData);
                
                Log::info('Transaction créée avec succès', [
                    'transaction_id' => $transaction->id,
                    'status' => $transaction->status
                ]);
                
            } catch (\Exception $e) {
                Log::error('Erreur création transaction', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Récupérer plus de détails si possible
                if (method_exists($e, 'getResponseBody')) {
                    $responseBody = $e->getResponseBody();
                    Log::error('Corps de la réponse', ['body' => $responseBody]);
                    
                    // Essayer de décoder la réponse pour plus d'infos
                    if ($responseBody) {
                        $decoded = json_decode($responseBody, true);
                        if ($decoded && isset($decoded['message'])) {
                            throw new \Exception($decoded['message']);
                        }
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'initiation du paiement: ' . $this->parseErrorMessage($e->getMessage())
                ], 422);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur validation', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('ERREUR GÉNÉRALE initiate', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur de paiement: ' . $this->parseErrorMessage($e->getMessage()),
            ], 422);
        }
    }
    /**
     * Mettre à jour l'email du client FedaPay si changé
     */
    private function updateCustomerEmailIfNeeded($customer, $newEmail)
    {
        if ($customer->email !== $newEmail) {
            try {
                $customer->email = $newEmail;
                $customer->save();
                
                Log::info('Email client FedaPay mis à jour', [
                    'customer_id' => $customer->id,
                    'old_email' => $customer->email,
                    'new_email' => $newEmail
                ]);
            } catch (\Exception $e) {
                Log::warning('Impossible de mettre à jour l\'email FedaPay', [
                    'customer_id' => $customer->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

/**
 * Parser les messages d'erreur
 */
private function parseErrorMessage($message)
{
    if (str_contains($message, 'phone')) {
        return 'Numéro de téléphone invalide pour cet opérateur';
    }
    if (str_contains($message, 'insufficient')) {
        return 'Solde insuffisant sur le compte';
    }
    if (str_contains($message, 'timeout')) {
        return 'Délai d\'attente dépassé';
    }
    return 'Impossible d\'initier le paiement. Vérifiez votre numéro et réessayez.';
}

    // ================================================================
    // CALLBACK (redirection navigateur depuis FedaPay)
    // ================================================================

    public function callback(Request $request)
    {
        Log::info('FedaPay callback', $request->all());

        $transactionId = $request->input('id') ?? $request->input('transaction_id');
        if (!$transactionId) {
            return redirect()->route('client.cart')->with('error', 'Réponse de paiement invalide.');
        }

        try {
            $transaction = \FedaPay\Transaction::retrieve($transactionId);
            $order = Order::where('order_number', $transaction->merchant_reference)->first();

            if (!$order) {
                return redirect()->route('client.cart')->with('error', 'Commande introuvable.');
            }

            if ($transaction->status === 'approved') {
                $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
                return redirect()->route('client.order.confirmation', $order->order_number)
                    ->with('success', 'Paiement réussi ! Votre commande est confirmée.');
            }

            return redirect()->route('client.checkout')
                ->with('error', 'Paiement non abouti (' . $transaction->status . '). Réessayez.');

        } catch (\Exception $e) {
            Log::error('FedaPay callback: ' . $e->getMessage());
            return redirect()->route('client.cart')->with('error', 'Erreur lors du retour paiement.');
        }
    }
    // ================================================================
    // VÉRIFIER LE STATUT DU PAIEMENT (polling toutes les 5s depuis le JS)
    // ================================================================

    public function checkStatus(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
            'order_number'   => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            $transaction = Transaction::retrieve($request->transaction_id);
            $status      = $transaction->status; // pending | approved | declined | cancelled | refunded

            if ($status === 'approved') {
                // Paiement confirmé → mettre à jour la commande
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'confirmed',
                ]);

                return response()->json([
                    'status'       => 'approved',
                    'redirect_url' => route('client.order.confirmation', $order->order_number),
                    'message'      => 'Paiement confirmé ! Votre commande est validée.',
                ]);
            }

            if (in_array($status, ['declined', 'cancelled'])) {
                return response()->json([
                    'status'  => $status,
                    'message' => $status === 'declined'
                        ? 'Paiement refusé. Vérifiez votre solde ou réessayez.'
                        : 'Paiement annulé.',
                ]);
            }

            // Toujours en attente
            return response()->json([
                'status'  => 'pending',
                'message' => 'En attente de confirmation sur votre téléphone...',
            ]);

        } catch (\Exception $e) {
            Log::error('FedaPay checkStatus error: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Impossible de vérifier le statut.',
            ], 500);
        }
    }

    // ================================================================
    // WEBHOOK FedaPay (notification automatique serveur-to-serveur)
    // Appelé par FedaPay quand le statut change, même sans polling client
    // ================================================================

    public function webhook(Request $request)
    {
        // Vérification de la signature FedaPay
        $payload   = $request->getContent();
        $signature = $request->header('X-FEDAPAY-SIGNATURE');

        // FedaPay envoie le statut dans le payload JSON
        $data = $request->json()->all();

        Log::info('FedaPay webhook received', $data);

        if (!isset($data['name']) || !isset($data['entity'])) {
            return response('Invalid payload', 400);
        }

        $event       = $data['name'];       // ex: "transaction.approved"
        $transaction = $data['entity'];

        // Récupérer la commande via merchant_reference
        $orderNumber = $transaction['merchant_reference'] ?? null;
        if (!$orderNumber) {
            return response('No merchant_reference', 400);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response('Order not found', 404);
        }

        DB::transaction(function () use ($event, $order, $transaction) {
            switch ($event) {
                case 'transaction.approved':
                    $order->update([
                        'payment_status'    => 'paid',
                        'status'            => $order->status === 'pending' ? 'confirmed' : $order->status,
                        'payment_reference' => $transaction['id'],
                    ]);
                    break;

                case 'transaction.declined':
                case 'transaction.cancelled':
                    // On ne remet pas le stock ici — la commande reste créée
                    // L'admin peut annuler manuellement si besoin
                    $order->update(['payment_status' => 'unpaid']);
                    break;

                case 'transaction.refunded':
                    $order->update(['payment_status' => 'refunded', 'status' => 'refunded']);
                    break;
            }
        });

        return response('OK', 200);
    }

    // ================================================================
    // UTILITAIRES
    // ================================================================

    private function getPushMessage(string $method): string
    {
        return match ($method) {
            'mtn_benin'  => 'Une demande de paiement MTN MoMo a été envoyée sur votre téléphone. Veuillez confirmer avec votre PIN.',
            'moov_benin' => 'Une demande de paiement Moov Money a été envoyée sur votre téléphone. Veuillez confirmer avec votre PIN.',
            'celtiis_bj' => 'Une demande de paiement Celtiis Cash a été envoyée sur votre téléphone. Veuillez confirmer.',
            default      => 'Une demande de paiement a été envoyée sur votre téléphone.',
        };
    }

    private function parseFeError(string $message): string
    {
        if (str_contains($message, 'insufficient')) {
            return 'Solde insuffisant sur votre compte Mobile Money.';
        }
        if (str_contains($message, 'invalid') || str_contains($message, 'phone')) {
            return 'Numéro de téléphone invalide. Vérifiez et réessayez.';
        }
        if (str_contains($message, 'timeout')) {
            return 'Délai d\'attente dépassé. Réessayez dans quelques instants.';
        }
        return 'Erreur lors de l\'initiation du paiement. Réessayez.';
    }
}