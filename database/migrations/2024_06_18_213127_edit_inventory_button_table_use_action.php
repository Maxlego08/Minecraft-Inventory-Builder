<?php

use App\Models\Builder\InventoryButton;
use App\Models\Builder\InventoryButtonAction;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        /*$lastButton = InventoryButton::orderBy('id', 'desc')->first();
        for ($i = 1; $i <= $lastButton->id; $i++) {
            \App\Jobs\UpdateInventoryButtonJob::dispatch($i);
        }*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
