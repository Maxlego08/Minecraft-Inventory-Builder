<?php

use App\Models\Payment\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->string('icon');
            $table->timestamps();
        });

        Currency::create([
            'currency' => 'eur',
            'icon' => '€'
        ]);

        Currency::create([
            'currency' => 'usd',
            'icon' => '$'
        ]);

        Currency::create([
            'currency' => 'gbp',
            'icon' => '£'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_currencies');
    }
};
