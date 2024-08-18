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
        Schema::create('inventory_button_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_button_id')->constrained();
            $table->foreignId('inventory_action_type_id')->constrained();
            $table->longText("data");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_button_actions');
    }
};
