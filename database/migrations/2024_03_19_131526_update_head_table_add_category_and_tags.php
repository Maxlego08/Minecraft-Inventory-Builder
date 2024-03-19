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
        Schema::table('heads', function (Blueprint $table) {
            $table->text('tags')->nullable()->after('url_id');
            $table->text('category')->nullable()->after('url_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heads', function (Blueprint $table) {
            $table->dropColumn('tags');
            $table->dropColumn('category');
        });
    }
};
