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
            'data_type' => 'text',
            'description' => 'Name of the plugin from where the inventory comes from. It is advisable to specify the plugin name to avoid opening another inventory with the same name.',
            'documentation_url' => 'https://docs.zmenu.dev/configurations/buttons#inventory',
        ]);

        ButtonTypeContent::create([
            'type_id' => 2,
            'key' => 'inventory',
            'data_type' => 'text',
            'description' => 'Name of the inventory you want to open. The name of the inventory will be the name of the inventory file.',
            'documentation_url' => 'https://docs.zmenu.dev/configurations/buttons#inventory',
        ]);

        ButtonTypeContent::create([
            'type_id' => 2,
            'key' => 'toPage',
            'data_type' => 'number',
            'description' => 'Number of the page you want to open. Default will be 1.',
            'documentation_url' => 'https://docs.zmenu.dev/configurations/buttons#inventory',
        ]);

        ButtonTypeContent::create([
            'type_id' => 2,
            'key' => 'arguments',
            'data_type' => 'textarea',
            'description' => 'List of arguments you can add. An argument can contain a name in the following format: <name>:<value>',
            'documentation_url' => 'https://docs.zmenu.dev/configurations/buttons#inventory',
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
