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
        Schema::create('alerts_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('content');
            $table->string('icon')->nullable();
            $table->string('translation_key')->nullable();
            $table->string('level')->default('light');
            $table->foreignId('target_id')->nullable()->constrained('users');
            $table->string('link')->nullable();
            $table->timestamp('opened_at')->nullable();
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
        Schema::dropIfExists('alerts_user');
    }
};
