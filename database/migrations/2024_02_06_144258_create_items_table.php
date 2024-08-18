<?php

use App\Models\Builder\Item;
use App\Models\MinecraftVersion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('version_id')->constrained();
            $table->string('name');
            $table->string('css');
            $table->integer('minecraft_id')->nullable();
            $table->string('material');
            $table->string('old_material')->nullable();
            $table->unsignedInteger('max_stack_size')->default(64);
            $table->timestamps();
        });

        $path = storage_path() . '/app/rendered.json';
        $json = json_decode(file_get_contents($path), true);
        $collections = collect();

        foreach ($json as $value) {
            $version = MinecraftVersion::where('minecraft_version', $value['item']['version'] ?? 1.08)->first();
            $collections->add([
                'version_id' => $version?->id ?? 1,
                'id' => $value['item']['id'] ?? 'empty',
                'name' => $value['name'],
                'data' => $value['item']['data'] ?? 0,
                'css' => $value['css'],
                'material' => $value['item']['material'],
                'old_material' => $value['item']['oldMaterial'] ?? null,
                'max_stack_size' => $value['item']['max'] ?? 64,
            ]);
        }

        $collections = $collections->sortBy(['id', 'data']);

        foreach ($collections as $collection) {
            $collection['minecraft_id'] = $collection['id'] === 'empty' ? null : $collection['id'];
            Item::create($collection);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
