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
            $table->boolean('is_permanent')->default(false);
            $table->boolean('close_inventory')->default(false);
            $table->boolean('refresh_on_click')->default(false);
            $table->boolean('update_on_click')->default(false);
            $table->boolean('update')->default(false);

            $table->integer('amount')->default(1);
            $table->text('display_name')->nullable();
            $table->text('lore')->nullable();
            $table->integer('data')->default(0);
            $table->integer('durability')->default(0);
            $table->longText('url')->nullable();
            $table->boolean('glow')->default(false);
            $table->integer('model_id')->default(0);
            $table->longText('enchants')->nullable();
            $table->longText('flags')->nullable();

            $table->longText('data')->nullable();

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
