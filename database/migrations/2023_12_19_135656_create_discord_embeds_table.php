<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discord_embeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discord_id')->constrained('discord_notifications');
            $table->string("title")->nullable();
            $table->string("color")->nullable();
            $table->string("footer")->nullable();
            $table->longText('description')->nullable();
            $table->longText('url_embed')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discord_embeds');
    }
};
