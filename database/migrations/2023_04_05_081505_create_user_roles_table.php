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
            $table->integer('max_inventories');
            $table->integer('max_folders');
            $table->boolean('premium_resources');
            $table->integer('power');
            $table->integer('max_discord_webhook');
            $table->boolean('is_banned');
            $table->double('price')->default(0.0);
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
            'max_inventories' => 0,
            'max_folders' => 0,
            'max_discord_webhook' => 0,

            'is_banned' => true,
        ]);

        UserRole::create([
            'name' => 'Member',
            'total_size' => 1024000 * 50, // 50 MO
            'size' => 1024000 * 2, // 2 MO
            'allow_files' => 'jpeg,png,jpg',
            'max_resources' => 10,
            'premium_resources' => false,
            'power' => 1,
            'max_inventories' => 100,
            'max_folders' => 10,
            'max_discord_webhook' => 0,
            'is_banned' => false,
        ]);

        UserRole::create([
            'name' => 'Premium',
            'total_size' => 1024000 * 500, // 500 MO
            'size' => 1024000 * 10, // 10 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 50,
            'premium_resources' => true,
            'power' => 2,
            'max_inventories' => 1000,
            'max_folders' => 100,
            'max_discord_webhook' => 5,
            'is_banned' => false,
            'price' => 14.99
        ]);

        UserRole::create([
            'name' => 'Pro',
            'total_size' => 1024000 * 1000 * 2, //2go
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 1000,
            'premium_resources' => true,
            'power' => 3,
            'max_inventories' => 10000,
            'max_folders' => 1000,
            'max_discord_webhook' => 20,
            'is_banned' => false,
            'price' => 49.99
        ]);

        UserRole::create([
            'name' => 'Moderator',
            'total_size' => 1024000 * 1000 * 2, // 2go
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 1000,
            'premium_resources' => true,
            'power' => 50,
            'max_inventories' => 10000,
            'max_folders' => 1000,
            'max_discord_webhook' => 20,
            'is_banned' => false,
        ]);

        UserRole::create([
            'name' => 'Admin',
            'total_size' => 1024000 * 1000 * 5, // 5go
            'size' => 1024000 * 50, // 50 MO
            'allow_files' => 'jpeg,png,jpg,gif',
            'max_resources' => 1000,
            'premium_resources' => true,
            'power' => 100,
            'max_inventories' => 10000,
            'max_folders' => 1000,
            'max_discord_webhook' => 20,
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
