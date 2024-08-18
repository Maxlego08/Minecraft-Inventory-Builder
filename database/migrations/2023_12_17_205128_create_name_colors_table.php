<?php

use App\Models\User\NameColor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_name_colors', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->double('price');
            $table->timestamps();
        });

        NameColor::create(['code' => 'username-color-blue-violet', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-orange-pink', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-turquoise-blue', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-green-blue', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-purple-pink', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-red-orange', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-lightblue-darkblue', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-pink-purple', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-blue-aqua', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-teal-magenta', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunset', 'price' => 2.0]);
        // NameColor::create(['code' => 'username-color-royal-blue', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-neon-life', 'price' => 10.0]);
        NameColor::create(['code' => 'username-color-flare', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-lush', 'price' => 2.0]);
        // NameColor::create(['code' => 'username-color-frost', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-mauve', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-aqua-splash', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-berry-bliss', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunny-morning', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-azure-lane', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-pink-passion', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunset-beach', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-crimson-tide', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-forest-hues', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-ocean-wave', 'price' => 5.0]);
        NameColor::create(['code' => 'username-color-lavender-blush', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-fiery-fuchsia', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-citrus-peel', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-winter-neva', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-velvet-sun', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-plum-plate', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-summer-breeze', 'price' => 5.0]);
        NameColor::create(['code' => 'username-color-mystic-sunset', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-dreamy-rainbow', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-cosmic-dance', 'price' => 10.0]);
        NameColor::create(['code' => 'username-color-aurora-sky', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-ocean-mirage', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-tropical-fade', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-orchid-bliss', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-spring-awakening', 'price' => 3.0]);
        NameColor::create(['code' => 'username-color-pink-serenade', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunset-glow', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-magic-meadow', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-icy-mint', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-blazing-sunset', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-ocean-breeze', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunset-dream', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-emerald-light', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-lavender-field', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-fiery-rose', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-autumn-hues', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-mint-freshness', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-twilight-spark', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-berry-blend', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-citrus-sunlight', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-spring-morning', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-coral-reef', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-aurora-gleam', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-forest-dew', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-summer-twilight', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-winter-whisper', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-desert-dusk', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunset-serenade', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-rainbow-bliss', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-twilight-haze', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-serene-sea', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-burning-sky', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-mystic-forest', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-autumn-blaze', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-polar-lights', 'price' => 8.0]);
        NameColor::create(['code' => 'username-color-dreamy-pink', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-sunset-glow2', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-arctic-dawn', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-lush-garden', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-berry-fusion', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-neon-breeze', 'price' => 5.0]);
        NameColor::create(['code' => 'username-color-oceanic-depth', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-citrus-rush', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-cherry-blossom', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-frosted-mint', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-vintage-rose', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-glacial-stream', 'price' => 2.0]);
        NameColor::create(['code' => 'username-color-golden-sunset', 'price' => 5.0]);
        NameColor::create(['code' => 'username-color-moonlit-asteroid', 'price' => 100.0]);
        NameColor::create(['code' => 'username-color-midnight-flame', 'price' => 100.0]);
        NameColor::create(['code' => 'username-color-moonlit-night', 'price' => 100.0]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_name_colors');
    }
};
