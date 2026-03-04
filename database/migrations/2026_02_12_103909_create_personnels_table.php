<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('date_naissance')->nullable();
            $table->string('genre');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('ville_de_residence');
            $table->string('nationalite');
            $table->string('code_postal')->nullable();
            $table->string('photo_profil')->nullable();
            $table->string('statut_profil')->default(1);
            $table->text('a_propos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
