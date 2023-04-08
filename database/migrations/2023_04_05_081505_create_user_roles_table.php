<?php

use App\Models\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('total_size');
            $table->bigInteger('size');
            $table->string('allow_files');
            $table->integer('max_resources');
            $table->boolean('premium_resources');
            $table->timestamps();
        });

        UserRole::create([
            'name' => 'Free',
            'total_size' => 1024000 * 10, // 10 MO
            'size' => 1024000 * 2, // 2 MO
            'allow_files' => 'jpeg,png,jpg',
            'max_resources' => 10,
            'premium_resources' => false,
        ]);

        UserRole::create([
            'name' => 'Pro',
            'total_size' => 1024000 * 100, // 100 MO
            'size' => 1024000 * 10, // 10 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 50,
            'premium_resources' => true,
        ]);

        UserRole::create([
            'name' => 'Premium',
            'total_size' => 1024000 * 500, // 500 MO
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 100,
            'premium_resources' => true,
        ]);

        UserRole::create([
            'name' => 'Admin',
            'total_size' => 1024000 * 5000, // 500 MO
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 1000,
            'premium_resources' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
