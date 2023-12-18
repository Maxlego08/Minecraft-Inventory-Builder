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
        Schema::table('resource_resources', function (Blueprint $table) {
            $table->foreignId('version_id')->nullable()->constrained('resource_versions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_resources', function (Blueprint $table) {
            $table->dropForeign('resource_resources_version_id_foreign');
            $table->dropColumn('version_id');
        });
    }
};
