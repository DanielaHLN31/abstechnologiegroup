<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminNotification;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckAdminNotifications extends Command
{
    protected $signature   = 'admin:check-notifications';
    protected $description = 'Vérifie et génère les notifications admin (commandes, stock, etc.)';

    public function handle(): void
    {
        $this->info('🔔 Vérification des notifications admin...');

        $this->checkNewPendingOrders();
        $this->checkProcessingOrders();
        $this->checkCancelledPaidOrders();
        $this->checkLowStockProducts();
        $this->checkOutOfStockProducts();

        $this->info('✅ Notifications mises à jour avec succès.');
        Log::info('[AdminNotifications] Vérification terminée à ' . now()->toDateTimeString());
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 1. Nouvelles commandes en attente (pending)
    // ─────────────────────────────────────────────────────────────────────────
    private function checkNewPendingOrders(): void
    {
        $pendingOrders = Order::with('user')
            ->where('status', 'pending')
            ->get();

        foreach ($pendingOrders as $order) {
            $this->createOrRemind(
                type:       'new_order',
                entityType: 'order',
                entityId:   $order->id,
                entityRef:  $order->order_number,
                title:      '🛒 Nouvelle commande en attente',
                message:    "La commande #{$order->order_number} de " .
                            ($order->user->name ?? $order->shipping_fullname) .
                            " ({$order->total_fmt}) attend votre traitement.",
            );
        }

        $this->line("  → {$pendingOrders->count()} commande(s) en attente vérifiée(s).");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 2. Commandes en traitement (confirmed / processing / shipped)
    // ─────────────────────────────────────────────────────────────────────────
    private function checkProcessingOrders(): void
    {
        $processingOrders = Order::with('user')
            ->whereIn('status', ['confirmed', 'processing', 'shipped'])
            ->get();

        foreach ($processingOrders as $order) {
            $statusLabel = match($order->status) {
                'confirmed'  => 'confirmée',
                'processing' => 'en préparation',
                'shipped'    => 'expédiée',
                default      => $order->status,
            };

            $this->createOrRemind(
                type:       'processing_order',
                entityType: 'order',
                entityId:   $order->id,
                entityRef:  $order->order_number,
                title:      '⏳ Commande en cours de traitement',
                message:    "La commande #{$order->order_number} est {$statusLabel} depuis " .
                            $order->updated_at->diffForHumans() . ". Client : " .
                            ($order->user->name ?? $order->shipping_fullname) . ".",
            );
        }

        $this->line("  → {$processingOrders->count()} commande(s) en traitement vérifiée(s).");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 3. Commandes annulées mais déjà payées (non remboursées)
    // ─────────────────────────────────────────────────────────────────────────
    private function checkCancelledPaidOrders(): void
    {
        $cancelledPaid = Order::with('user')
            ->where('status', 'cancelled')
            ->where('payment_status', 'paid')  // payée mais non remboursée
            ->get();

        foreach ($cancelledPaid as $order) {
            $this->createOrRemind(
                type:       'cancelled_paid',
                entityType: 'order',
                entityId:   $order->id,
                entityRef:  $order->order_number,
                title:      '⚠️ Remboursement requis',
                message:    "La commande #{$order->order_number} de " .
                            ($order->user->name ?? $order->shipping_fullname) .
                            " a été annulée mais le paiement de " .
                            number_format($order->total, 0, ',', ' ') .
                            " FCFA n'a pas encore été remboursé.",
            );
        }

        $this->line("  → {$cancelledPaid->count()} commande(s) annulée(s) non remboursée(s).");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 4. Produits atteignant leur seuil de stock faible (low stock)
    // ─────────────────────────────────────────────────────────────────────────
    private function checkLowStockProducts(): void
    {
        // Produits publiés dont stock > 0 mais <= seuil
        $lowStock = Product::where('status', 'published')
            ->where('in_stock', true)
            ->whereRaw('stock_quantity <= low_stock_threshold')
            ->where('stock_quantity', '>', 0)
            ->get();

        foreach ($lowStock as $product) {
            $this->createOrRemind(
                type:       'low_stock',
                entityType: 'product',
                entityId:   $product->id,
                entityRef:  $product->name,
                title:      '📦 Stock faible',
                message:    "Le produit \"{$product->name}\" n'a plus que {$product->stock_quantity} unité(s) en stock " .
                            "(seuil : {$product->low_stock_threshold}). Pensez à réapprovisionner.",
            );
        }

        $this->line("  → {$lowStock->count()} produit(s) en stock faible.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 5. Produits en rupture de stock (out of stock)
    // ─────────────────────────────────────────────────────────────────────────
    private function checkOutOfStockProducts(): void
    {
        $outOfStock = Product::where('status', 'published')
            ->where(function ($q) {
                $q->where('in_stock', false)
                  ->orWhere('stock_quantity', '<=', 0);
            })
            ->get();

        foreach ($outOfStock as $product) {
            $this->createOrRemind(
                type:       'out_of_stock',
                entityType: 'product',
                entityId:   $product->id,
                entityRef:  $product->name,
                title:      '🚫 Rupture de stock',
                message:    "Le produit \"{$product->name}\" est en rupture totale de stock et reste visible sur la boutique. Action requise.",
            );
        }

        $this->line("  → {$outOfStock->count()} produit(s) en rupture de stock.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper : créer une nouvelle notification OU mettre à jour le rappel
    // ─────────────────────────────────────────────────────────────────────────
    private function createOrRemind(
        string  $type,
        ?string $entityType,
        ?int    $entityId,
        ?string $entityRef,
        string  $title,
        string  $message,
    ): void {
        $config = AdminNotification::typeConfig($type);

        $shouldNotify = AdminNotification::shouldNotify($type, $entityType, $entityId);

        if ($shouldNotify) {
            // Vérifier si une notification non-lue existe déjà (alors on rappelle, sinon on crée)
            $existing = AdminNotification::where('type', $type)
                ->where('entity_type', $entityType)
                ->where('entity_id', $entityId)
                ->where('is_read', false)
                ->latest()
                ->first();

            if ($existing) {
                // Rappel : mettre à jour le message et incrémenter le compteur
                $existing->update([
                    'message'          => $message,
                    'last_reminded_at' => now(),
                    'reminder_count'   => $existing->reminder_count + 1,
                ]);
            } else {
                // Création d'une nouvelle notification
                AdminNotification::create([
                    'type'             => $type,
                    'title'            => $title,
                    'message'          => $message,
                    'icon'             => $config['icon'],
                    'color'            => $config['color'],
                    'entity_type'      => $entityType,
                    'entity_id'        => $entityId,
                    'entity_ref'       => $entityRef,
                    'is_read'          => false,
                    'last_reminded_at' => now(),
                    'reminder_count'   => 0,
                ]);
            }
        }
    }
}