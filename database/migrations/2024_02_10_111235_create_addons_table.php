<?php

use App\Models\Builder\Addon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resource_resources')->onDelete('cascade');
            $table->string('name');
            $table->longText('description');
            $table->boolean('is_official')->default(false);
            $table->timestamps();
        });

        Addon::create([
            'resource_id' => 1,
            'name' => 'zMenu',
            'description' => 'zMenu plugin',
            'is_official' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_addons');
    }
};
