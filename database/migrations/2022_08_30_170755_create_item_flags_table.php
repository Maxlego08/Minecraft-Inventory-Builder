<?php

use App\Models\ItemFlag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_flags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('version')->default(1.08);
            $table->timestamps();
        });

        ItemFlag::create(['name' => 'HIDE_ATTRIBUTES']);
        ItemFlag::create(['name' => 'HIDE_DESTROYS']);
        ItemFlag::create(['name' => 'HIDE_ENCHANTS']);
        ItemFlag::create(['name' => 'HIDE_PLACED_ON']);
        ItemFlag::create(['name' => 'HIDE_POTION_EFFECTS']);
        ItemFlag::create(['name' => 'HIDE_UNBREAKABLE']);
        ItemFlag::create(['name' => 'HIDE_DYE', 'version' => 1.17]);
        ItemFlag::create(['name' => 'HIDE_ARMOR_TRIM', 'version' => 1.20]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_flags');
    }
};
