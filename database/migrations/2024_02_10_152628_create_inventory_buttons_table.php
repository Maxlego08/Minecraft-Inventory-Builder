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
        Schema::create('inventory_buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('else_button_id')->nullable();
            $table->foreignId('inventory_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('type_id')->constrained('inventory_button_types');
            $table->string('name');
            $table->string('slot');

            $table->longText('messages')->nullable();
            $table->longText('commands')->nullable();
            $table->integer('page')->default(1);
            $table->boolean('isPermanent')->default(false);
            $table->boolean('closeInventory')->default(false);
            $table->boolean('refreshOnClick')->default(false);
            $table->boolean('updateOnClick')->default(false);
            $table->boolean('update')->default(false);
            $table->integer('amount')->default(1);
            $table->text('display_name')->nullable();
            $table->text('lore')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_buttons');
    }
};
