<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gift_id')->nullable();
            $table->foreignId('currency_id')->nullable('payment_currencies');
            $table->string('external_id')->nullable();
            $table->string('payment_id');
            $table->string('content_id');
            $table->double('price');
            $table->string('status');
            $table->integer('type');
            $table->string('gateway');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_payments');
    }
};
