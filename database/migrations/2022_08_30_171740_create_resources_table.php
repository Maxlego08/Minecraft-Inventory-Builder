<?php

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
        Schema::create('resource_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('resource_categories');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('image_id')->constrained('files');
            $table->string('name', 255);
            $table->double('price')->default(0);
            $table->longText('description');
            $table->string('tag');
            $table->boolean('is_display')->default(true);
            $table->boolean('is_pending')->default(true);
            $table->longText('source_code_link')->nullable();
            $table->longText('donation_link')->nullable();
            $table->string('discord_server_id')->nullable();
            $table->longText('required_dependencies')->nullable();
            $table->longText('optional_dependencies')->nullable();
            $table->longText('supported_languages')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_resources');
    }
};
