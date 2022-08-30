<?php

use App\Models\MinecraftVersion;
use Carbon\Carbon;
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
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->double('minecraft_version');
            $table->timestamp('released_at');
            $table->timestamps();
        });

        MinecraftVersion::create([
            'version' => '1.19',
            'minecraft_version' => 1.19,
            'released_at' => Carbon::create(2022, 6, 7),
        ]);

        MinecraftVersion::create([
            'version' => '1.18',
            'minecraft_version' => 1.18,
            'released_at' => Carbon::create(2021, 11, 30),
        ]);

        MinecraftVersion::create([
            'version' => '1.17',
            'minecraft_version' => 1.17,
            'released_at' => Carbon::create(2021, 6, 8),
        ]);

        MinecraftVersion::create([
            'version' => '1.16',
            'minecraft_version' => 1.16,
            'released_at' => Carbon::create(2020, 6, 23),
        ]);

        MinecraftVersion::create([
            'version' => '1.15',
            'minecraft_version' => 1.15,
            'released_at' => Carbon::create(2019, 12, 10),
        ]);

        MinecraftVersion::create([
            'version' => '1.14',
            'minecraft_version' => 1.14,
            'released_at' => Carbon::create(2019, 4, 23),
        ]);

        MinecraftVersion::create([
            'version' => '1.13',
            'minecraft_version' => 1.13,
            'released_at' => Carbon::create(2018, 7, 18),
        ]);

        MinecraftVersion::create([
            'version' => '1.12',
            'minecraft_version' => 1.12,
            'released_at' => Carbon::create(2017, 6, 7),
        ]);

        MinecraftVersion::create([
            'version' => '1.11',
            'minecraft_version' => 1.11,
            'released_at' => Carbon::create(2016, 11, 14),
        ]);

        MinecraftVersion::create([
            'version' => '1.10',
            'minecraft_version' => 1.10,
            'released_at' => Carbon::create(2016, 6, 8),
        ]);

        MinecraftVersion::create([
            'version' => '1.9',
            'minecraft_version' => 1.09,
            'released_at' => Carbon::create(2016, 2, 29),
        ]);

        MinecraftVersion::create([
            'version' => '1.8',
            'minecraft_version' => 1.08,
            'released_at' => Carbon::create(2014, 9, 2),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versions');
    }
};
