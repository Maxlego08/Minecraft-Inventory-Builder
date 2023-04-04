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
        Schema::create('discord_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('discord_id');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->dateTime('expired_at');
            $table->string('username');
            $table->string('email');
            $table->string('discriminator');
            $table->string('avatar');
            $table->boolean('is_valid');
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
        Schema::dropIfExists('discord_users');
    }
};
