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
            $table->timestamps();
        });

        ActionType::create([
            'addon_id' => 1,
            'name' => 'player_command',
            'description' => 'Execute commands as the player. You can send the command in the player tchat.',
            'exampel' => '- type: player_command
  commands:
    - "firstcommand"
    - "seconds commands %player%"
  commandInChat: false # false by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'console_command',
            'description' => 'Execute commands as the console.',
            'exampel' => '- type: console_command
  commands:
    - "firstcommand"
    - "seconds commands %player%"',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'message',
            'description' => 'Send a message to the player. You can use placeholders and color/format codes here. Mini message format is enable by default if your server support it.',
            'exampel' => '- type: message
  messages:
    - "my message"
    - "my second messages"
  minimessage: true # true by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'broadcast',
            'description' => 'Send a message to the online players. You can use placeholders and color/format codes here. Mini message format is enable by default if your server support it.',
            'exampel' => '- type: broadcast
  messages:
    - "my message"
    - "my second message to %player%"
  minimessage: true # true by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'chat',
            'description' => 'Sends messages instead of the player.',
            'exampel' => '- type: chat
  messages:
    - "my message"',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'close',
            'description' => 'Closes the player’s inventory.',
            'exampel' => '- type: close',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'inventory',
            'description' => 'Opens an inventory of zMenu.',
            'exampel' => '- type: inventory
  inventory: <inventory name>
  plugin: <plugin name>
  page: <page>
  arguments: <argument list>',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'connect',
            'description' => 'Allows sending the player to another server, only works with BungeeCord and Velocity.',
            'exampel' => '- type: connect
  server: <server name>',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'sound',
            'description' => 'Send a sound to a player, you must use XSound for sound.',
            'exampel' => '- type: sound
  sound: <xsound>
  pitch: <sound pitch> # 1.0f by default
  volume: <sound volume> # 1.0f by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'broadcast_sound',
            'description' => 'Send a sound to the online players, you must use XSound for sound.',
            'exampel' => '- type: broadcast_sound
  sound: <xsound>
  pitch: <sound pitch> # 1.0f by default
  volume: <sound volume> # 1.0f by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'data',
            'description' => 'Update player data.',
            'exampel' => '- type: data
  action: <SET/REMOVE/ADD/SUBTRACT>
  key: <data key>
  value: <data value>
  seconds: <expire seconds> # 0 by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'refresh',
            'description' => 'Refresh current button. Work only in click requirement',
            'exampel' => '- type: refresh',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'back',
            'description' => 'Return to previous inventory.',
            'exampel' => '- type: back',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'shopkeeeper',
            'description' => 'Open a Shopkeeper trading inventory',
            'exampel' => '- type: shopkeeper
  name: <shopkeeper name>',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'book',
            'description' => 'Open a book',
            'exampel' => "- type: book
  author: 'Maxlego08' # Book author
  title: '&cTest' # Book title
  lines: # Book pages
    1: # First page
      - '     #34ebe8zMenu'
      - ''
      - ''
      - '<hover:show_text:"#34eba8Open an url !"><click:open_url:"https://minecraft-inventory-builder.com/">#f0af24Open URL<reset>'",
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'actionbar',
            'description' => 'Allows to send a message in the action bar of the player',
            'exampel' => '- type: actionbar
  message: "my message"
  minimessage: true # true by default',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'withdraw',
            'description' => 'Allows you to withdraw money from the player’s account. Works with the Vault.',
            'exampel' => '- type: withdraw
  amount: <amount>',
        ]);

        ActionType::create([
            'addon_id' => 1,
            'name' => 'deposit',
            'description' => 'Allows you to deposit money from the player’s account. Works with the Vault.',
            'exampel' => '- type: deposit
  amount: <amount>',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_action_types');
    }
};
