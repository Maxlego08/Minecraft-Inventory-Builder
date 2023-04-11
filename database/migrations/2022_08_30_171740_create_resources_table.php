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
            $table->foreignId('version_id')->nullable()->constrained('resource_versions');
            $table->foreignId('image_id')->constrained('files');
            $table->string('name', 100);
            $table->double('price')->default(0);
            $table->longText('description');
            $table->string('tag', 150);
            $table->boolean('is_display')->default(true);
            $table->boolean('is_pending')->default(true);
            $table->longText('versions')->nullable();
            $table->longText('version_base_mc')->nullable();
            $table->longText('source_code_link')->nullable();
            $table->longText('contributors')->nullable();
            $table->longText('link_information')->nullable();
            $table->longText('link_support')->nullable();
            $table->longText('lang_support')->nullable();
            $table->longText('donation_link')->nullable();
            $table->string('discord_server_id')->nullable();
            $table->string('bstats_id')->nullable();
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
