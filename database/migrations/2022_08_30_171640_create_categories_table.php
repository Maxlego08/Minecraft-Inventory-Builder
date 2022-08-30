<?php

use App\Models\Resource\Category;
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
        Schema::create('resource_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('resource_categories');
            $table->timestamps();
        });

        $categoryConfiguration = Category::create([
            'name' => 'Configurations',
        ]);

        foreach (['Chat', 'Tools and Utilities', 'Misc', 'Fun', 'Mechanics', 'Economy'] as $name) {
            Category::create([
                'name' => $name,
                'category_id' => $categoryConfiguration->id
            ]);
        }

        Category::create([
            'name' => 'Addon',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_categories');
    }
};
