<?php
// ── Migration 1 : orders ─────────────────────────────────────────
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ex: ORD-20260223-0001

            // Client
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Adresse de livraison
            $table->string('shipping_fullname');
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_country')->default('Bénin');
            $table->text('shipping_notes')->nullable();

            // Montants
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            // Statut commande
            $table->enum('status', [
                'pending',      // En attente
                'confirmed',    // Confirmée
                'processing',   // En cours de traitement
                'shipped',      // Expédiée
                'delivered',    // Livrée
                'cancelled',    // Annulée
                'refunded',     // Remboursée
            ])->default('pending');

            // Paiement
            $table->enum('payment_method', [
                'cash_on_delivery',  // Paiement à la livraison
                'mobile_money',      // Mobile Money (MTN / Moov)
                'bank_transfer',     // Virement bancaire
            ])->default('cash_on_delivery');

            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'refunded',
            ])->default('unpaid');

            $table->string('payment_reference')->nullable(); // référence de transaction

            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};