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
            $table->integer('power');
            $table->boolean('is_banned');
            $table->timestamps();
        });

        UserRole::create([
            'name' => 'Banned',
            'total_size' => 0, // 10 MO
            'size' => 0, // 2 MO
            'allow_files' => 'jpeg,png,jpg',
            'max_resources' => 0,
            'premium_resources' => false,
            'power' => 0,
            'is_banned' => true,
        ]);

        UserRole::create([
            'name' => 'Member',
            'total_size' => 1024000 * 10, // 10 MO
            'size' => 1024000 * 2, // 2 MO
            'allow_files' => 'jpeg,png,jpg',
            'max_resources' => 10,
            'premium_resources' => false,
            'power' => 1,
            'is_banned' => false,
        ]);

        UserRole::create([
            'name' => 'Premium',
            'total_size' => 1024000 * 100, // 100 MO
            'size' => 1024000 * 10, // 10 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 50,
            'premium_resources' => true,
            'power' => 2,
            'is_banned' => false,
        ]);

        UserRole::create([
            'name' => 'Pro',
            'total_size' => 1024000 * 500, // 500 MO
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 100,
            'premium_resources' => true,
            'power' => 3,
            'is_banned' => false,
        ]);

        UserRole::create([
            'name' => 'Moderator',
            'total_size' => 1024000 * 500, // 500 MO
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 1000,
            'premium_resources' => true,
            'power' => 50,
            'is_banned' => false,
        ]);

        UserRole::create([
            'name' => 'Admin',
            'total_size' => 1024000 * 5000, // 500 MO
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 1000,
            'premium_resources' => true,
            'power' => 100,
            'is_banned' => false,
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
