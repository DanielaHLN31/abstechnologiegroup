<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class PaymentController extends Controller
{
    private function bootFedaPay(): void
    {
        \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
        \FedaPay\FedaPay::setEnvironment(config('services.fedapay.env', 'sandbox'));
    }

    public function callback(Request $request)
    {
        Log::info('FedaPay callback reçu', $request->all());

        $this->bootFedaPay();

        $transactionId = $request->input('id') ?? $request->input('transaction_id');

        if (!$transactionId) {
            Log::warning('FedaPay callback : aucun transaction_id reçu');
            return redirect()->route('client.cart')
                ->with('error', 'Réponse de paiement invalide.');
        }

        try {
            // Récupérer la transaction depuis l'API FedaPay
            // (ne pas faire confiance au paramètre ?status= de l'URL,
            //  toujours vérifier côté serveur)
            $transaction = \FedaPay\Transaction::retrieve($transactionId);

            $orderNumber = $transaction->merchant_reference
                ?? session('order_checkout.order_number');

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                Log::error('FedaPay callback : commande introuvable', [
                    'merchant_reference' => $orderNumber,
                    'transaction_id'     => $transactionId,
                ]);
                return redirect()->route('client.cart')
                    ->with('error', 'Commande introuvable.');
            }

            Log::info('FedaPay transaction status', [
                'status'         => $transaction->status,
                'transaction_id' => $transactionId,
                'order_number'   => $orderNumber,
            ]);

            if ($transaction->status === 'approved') {

                $order->update([
                    'payment_status'    => 'paid',
                    'status'            => 'confirmed',
                    'payment_reference' => $transactionId,
                ]);

                session()->forget('order_checkout');

                return redirect()
                    ->route('client.order.confirmation', $order->order_number)
                    ->with('success', 'Paiement réussi ! Votre commande est confirmée.');
            }

            // Paiement refusé ou annulé
            $order->update(['payment_status' => 'unpaid']);

            return redirect()
                ->route('client.checkout')
                ->with('error', 'Paiement non abouti (' . $transaction->status . '). Veuillez réessayer.');

        } catch (\Exception $e) {
            Log::error('FedaPay callback exception', ['message' => $e->getMessage()]);
            return redirect()->route('client.cart')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    // ================================================================
    // WEBHOOK — Notification serveur-to-serveur (filet de sécurité)
    // ================================================================
    public function webhook(Request $request)
    {
        $data = $request->json()->all();
        Log::info('FedaPay webhook reçu', $data);

        if (!isset($data['name']) || !isset($data['entity'])) {
            return response('Invalid payload', 400);
        }

        $event       = $data['name'];
        $transaction = $data['entity'];

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
                    $order->update(['payment_status' => 'unpaid']);
                    break;
                case 'transaction.refunded':
                    $order->update(['payment_status' => 'refunded', 'status' => 'refunded']);
                    break;
            }
        });

        return response('OK', 200);
    }
}