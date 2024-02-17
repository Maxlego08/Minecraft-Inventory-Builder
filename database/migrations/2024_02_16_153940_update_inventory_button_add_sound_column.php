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
        Schema::table('inventory_buttons', function (Blueprint $table) {
            // SOUND
            $table->string('sound')->after('button_data')->nullable();
            $table->float('pitch')->after('sound')->default(1.0);
            $table->float('volume')->after('pitch')->default(1.0);

            // COMMANDS
            $table->longText('commands')->after('button_data')->nullable();
            $table->longText('console_commands')->after('button_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_buttons', function (Blueprint $table) {
            $table->dropColumn('sound');
            $table->dropColumn('pitch');
            $table->dropColumn('volume');
            $table->dropColumn('commands');
            $table->dropColumn('console_commands');
        });
    }
};
