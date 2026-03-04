<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // pour les visiteurs non connectés
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Un utilisateur/session ne peut pas avoir le même produit+couleur deux fois
            $table->unique(['user_id', 'product_id', 'color_id'], 'cart_user_product_color');
            $table->unique(['session_id', 'product_id', 'color_id'], 'cart_session_product_color');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};