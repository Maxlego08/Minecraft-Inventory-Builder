<?php

use App\Models\Builder\ButtonTypeContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_button_type_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('inventory_button_types')->onDelete('cascade');
            $table->string('key');
            $table->longText('data_type');
            $table->longText('description')->nullable();
            $table->longText('documentation_url')->nullable();
            $table->timestamps();
        });

        ButtonTypeContent::create([
            'type_id' => 2,
            'key' => 'plugin',
            'data_type' => 'text'
        ]);

        ButtonTypeContent::create([
            'type_id' => 2,
            'key' => 'inventory',
            'data_type' => 'text'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_button_type_contents');
    }
};
