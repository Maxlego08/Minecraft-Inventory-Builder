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
        Schema::table('users', function (Blueprint $table) {
           // $table->id();
           // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('newsletter_active')->default(true);
            $table->timestamp('newsletter_at')->nullable();
            $table->string('newsletter_key', 64)->unique()->nullable();


            //
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('newsletter_active');
            $table->dropColumn('newsletter_at');
            $table->dropColumn('newsletter_key');

            //
        });
    }
};
