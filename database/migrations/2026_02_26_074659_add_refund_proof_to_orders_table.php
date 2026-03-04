<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('refund_proof')->nullable()->after('payment_proof');
            $table->timestamp('refunded_at')->nullable()->after('refund_proof');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['refund_proof', 'refunded_at']);
        });
    }
};