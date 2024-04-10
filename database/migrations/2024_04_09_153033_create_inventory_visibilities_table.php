<?php

use App\Models\Builder\InventoryVisibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_visibilities', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('name');
            $table->timestamps();
        });

        InventoryVisibility::create(['name' => 'private', 'type' => InventoryVisibility::PRIVATE]);
        InventoryVisibility::create(['name' => 'unlisted', 'type' => InventoryVisibility::UNLISTED]);
        InventoryVisibility::create(['name' => 'public', 'type' => InventoryVisibility::PUBLIC]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_visibilities');
    }
};
