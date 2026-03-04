<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();

            // Type de notification
            $table->enum('type', [
                'new_order',          // Nouvelle commande en attente
                'processing_order',   // Commande en traitement
                'cancelled_paid',     // Commande annulée mais payée (non remboursée)
                'low_stock',          // Produit à stock faible
                'out_of_stock',       // Produit en rupture de stock
                'new_review',         // Nouvel avis client (bonus)
                'revenue_milestone',  // Seuil de chiffre d'affaires atteint (bonus)
            ]);

            $table->string('title');
            $table->text('message');
            $table->string('icon')->default('ti-bell');
            $table->string('color')->default('primary'); // primary, warning, danger, info, success

            // Lien vers l'entité concernée
            $table->string('entity_type')->nullable(); // 'order', 'product'
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('entity_ref')->nullable(); // ex: order_number

            // Gestion de l'affichage
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // Gestion des rappels (on ne crée pas de doublon si déjà notifié dans les 24h)
            $table->timestamp('last_reminded_at')->nullable();
            $table->integer('reminder_count')->default(0);

            $table->timestamps();

            $table->index(['type', 'is_read']);
            $table->index(['entity_type', 'entity_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};