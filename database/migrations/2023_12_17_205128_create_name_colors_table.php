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
            $table->timestamps();
        });

        NameColor::create(['code' => 'username-color-blue-violet',]);
        NameColor::create(['code' => 'username-color-orange-pink',]);
        NameColor::create(['code' => 'username-color-turquoise-blue',]);
        NameColor::create(['code' => 'username-color-green-blue',]);
        NameColor::create(['code' => 'username-color-purple-pink',]);
        NameColor::create(['code' => 'username-color-red-orange',]);
        NameColor::create(['code' => 'username-color-lightblue-darkblue',]);
        NameColor::create(['code' => 'username-color-pink-purple',]);
        NameColor::create(['code' => 'username-color-blue-aqua',]);
        NameColor::create(['code' => 'username-color-teal-magenta',]);
        NameColor::create(['code' => 'username-color-sunset',]);
        NameColor::create(['code' => 'username-color-royal-blue',]);
        NameColor::create(['code' => 'username-color-neon-life',]);
        NameColor::create(['code' => 'username-color-flare',]);
        NameColor::create(['code' => 'username-color-lush',]);
        NameColor::create(['code' => 'username-color-frost',]);
        NameColor::create(['code' => 'username-color-mauve',]);
        NameColor::create(['code' => 'username-color-aqua-splash',]);
        NameColor::create(['code' => 'username-color-berry-bliss',]);
        NameColor::create(['code' => 'username-color-sunny-morning',]);
        NameColor::create(['code' => 'username-color-azure-lane',]);
        NameColor::create(['code' => 'username-color-pink-passion',]);
        NameColor::create(['code' => 'username-color-sunset-beach',]);
        NameColor::create(['code' => 'username-color-crimson-tide',]);
        NameColor::create(['code' => 'username-color-forest-hues',]);
        NameColor::create(['code' => 'username-color-ocean-wave',]);
        NameColor::create(['code' => 'username-color-lavender-blush',]);
        NameColor::create(['code' => 'username-color-fiery-fuchsia',]);
        NameColor::create(['code' => 'username-color-citrus-peel',]);
        NameColor::create(['code' => 'username-color-winter-neva',]);
        NameColor::create(['code' => 'username-color-velvet-sun',]);
        NameColor::create(['code' => 'username-color-plum-plate',]);
        NameColor::create(['code' => 'username-color-summer-breeze',]);
        NameColor::create(['code' => 'username-color-mystic-sunset',]);
        NameColor::create(['code' => 'username-color-dreamy-rainbow',]);
        NameColor::create(['code' => 'username-color-cosmic-dance',]);
        NameColor::create(['code' => 'username-color-aurora-sky',]);
        NameColor::create(['code' => 'username-color-ocean-mirage',]);
        NameColor::create(['code' => 'username-color-tropical-fade',]);
        NameColor::create(['code' => 'username-color-orchid-bliss',]);
        NameColor::create(['code' => 'username-color-spring-awakening',]);
        NameColor::create(['code' => 'username-color-moonlit-asteroid',]);
        NameColor::create(['code' => 'username-color-pink-serenade',]);
        NameColor::create(['code' => 'username-color-sunset-glow',]);
        NameColor::create(['code' => 'username-color-magic-meadow',]);
        NameColor::create(['code' => 'username-color-icy-mint',]);
        NameColor::create(['code' => 'username-color-blazing-sunset',]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_name_colors');
    }
};
