<?php

use App\Models\Builder\ActionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_action_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('addon_id')->constrained('inventory_addons')->onDelete('cascade');
            $table->string('name');
            $table->longText('description');
            $table->longText('example')->nullable();
            $table->longText('documentation_url')->nullable();
            $table->boolean('is_zmenu_plus')->default(false);
            $table->timestamps();
        });

        $actions = [
            [
                'name' => 'player command',
                'description' => 'Executes commands as the player. You can also send the command in the player\'s chat.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#player-command',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'random player command',
                'description' => 'Executes random commands as the player. You can also send the command in the player\'s chat.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#random-player-command',
                'is_zmenu_plus' => true,
            ],
            [
                'name' => 'console command',
                'description' => 'Executes commands as the console.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#console-command',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'random console command',
                'description' => 'Execute random commands from the list.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#random-console-command',
                'is_zmenu_plus' => true,
            ],
            [
                'name' => 'message',
                'description' => 'Sends a message to the player. You can use placeholders, color codes, and format codes. The MiniMessage format is enabled by default if your server supports it.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#message',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'broadcast',
                'description' => 'Sends a message to all online players. You can use placeholders, color codes, and format codes. The MiniMessage format is enabled by default if your server supports it.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#broadcast',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'chat',
                'description' => 'Sends messages on behalf of the player. You can use placeholders, color codes, and format codes. MiniMessage format is enabled by default if your server supports it.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#chat',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'close',
                'description' => 'Closes the player\'s inventory.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#close',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'inventory',
                'description' => 'Opens an inventory.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#inventory',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'connect',
                'description' => 'Allows sending the player to another server, only works with BungeeCord and Velocity.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#connect',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'sound',
                'description' => 'Send a sound to a player, you must use XSound for sound.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#sound',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'broadcast sound',
                'description' => 'Send a sound to the online players, you must use XSound for sound.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#broadcast-sound',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'data',
                'description' => 'Update player data.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#data',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'refresh',
                'description' => 'Refresh current button. Works only in click requirement.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#refresh',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'back',
                'description' => 'Return to previous inventory.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#back',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'shopkeeper',
                'description' => 'Open a Shopkeeper trading inventory.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#shopkeeper',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'book',
                'description' => 'Opens a book for the player. You can specify the title, author, and pages of the book.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#book',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'actionbar',
                'description' => 'Allows you to send a message in the action bar of the player. You can use placeholders and color/format codes here. MiniMessage format is enabled by default if your server supports it.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#actionbar',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'withdraw',
                'description' => 'Allows you to withdraw money from the player’s account. Works with the BeastTokens, Vault, PlayerPoints, ElementalTokens, ElementalGems, Level, Experience, zEssentials, EcoBits, CoinsEngine and VotingPlugin.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#withdraw',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'deposit',
                'description' => 'Allows you to deposit money from the player’s account. Works with the BeastTokens, Vault, PlayerPoints, ElementalTokens, ElementalGems, Level, Experience, zEssentials, EcoBits, CoinsEngine and VotingPlugin.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#deposit',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'title',
                'description' => 'Send a title. You can use placeholders and color/format codes here. MiniMessage format is enabled by default if your server supports it.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#title',
                'is_zmenu_plus' => false,
            ],
            [
                'name' => 'teleport',
                'description' => 'Teleport a player.',
                'example' => null,
                'documentation_url' => 'https://docs.zmenu.dev/configurations/actions#teleport',
                'is_zmenu_plus' => false,
            ],
        ];

        foreach ($actions as $action) {
            ActionType::create(array_merge($action, ['addon_id' => 1]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_action_types');
    }
};
