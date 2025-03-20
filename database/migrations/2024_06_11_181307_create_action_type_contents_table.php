<?php

use App\Models\Builder\ActionTypeContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_action_type_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('inventory_action_types')->onDelete('cascade');
            $table->string('key');
            $table->longText('data_type');
            $table->longText('description')->nullable();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        // Assuming type_id starts from 1 and increments sequentially
        $actionTypeContents = [
            // player_command
            [
                'type_id' => 1,
                'key' => 'commands',
                'data_type' => 'textarea',
                'description' => 'Commands that the player must perform',
            ],
            [
                'type_id' => 1,
                'key' => 'command-in-chat',
                'data_type' => 'bool',
                'value' => 'false',
                'description' => 'Allows to execute commands in chat',
            ],

            // random_player_command
            [
                'type_id' => 2,
                'key' => 'commands',
                'data_type' => 'textarea',
                'description' => 'Random commands that the player must perform',
            ],
            [
                'type_id' => 2,
                'key' => 'amount',
                'data_type' => 'integer',
                'value' => '1',
                'description' => 'integer of random commands to execute',
            ],
            [
                'type_id' => 2,
                'key' => 'command-in-chat',
                'data_type' => 'bool',
                'value' => 'false',
                'description' => 'Allows to execute commands in chat',
            ],

            // console_command
            [
                'type_id' => 3,
                'key' => 'commands',
                'data_type' => 'textarea',
                'description' => 'Commands that the console must perform',
            ],

            // random_console_command
            [
                'type_id' => 4,
                'key' => 'commands',
                'data_type' => 'textarea',
                'description' => 'Random commands that the console must perform',
            ],
            [
                'type_id' => 4,
                'key' => 'amount',
                'data_type' => 'integer',
                'value' => '1',
                'description' => 'integer of random commands to execute',
            ],

            // message
            [
                'type_id' => 5,
                'key' => 'messages',
                'data_type' => 'textarea',
                'description' => 'Messages to send to the player',
            ],
            [
                'type_id' => 5,
                'key' => 'mini-message',
                'data_type' => 'bool',
                'value' => 'true',
                'description' => 'Enable MiniMessage format if supported',
            ],

            // broadcast
            [
                'type_id' => 6,
                'key' => 'messages',
                'data_type' => 'textarea',
                'description' => 'Messages to broadcast to all online players',
            ],
            [
                'type_id' => 6,
                'key' => 'mini-message',
                'data_type' => 'bool',
                'value' => 'true',
                'description' => 'Enable MiniMessage format if supported',
            ],

            // chat
            [
                'type_id' => 7,
                'key' => 'messages',
                'data_type' => 'textarea',
                'description' => 'Messages to send on behalf of the player',
            ],

            // close
            /*[
                'type_id' => 8,
                'key' => 'action',
                'data_type' => 'string',
                'description' => 'Close the player\'s inventory',
            ],*/

            // inventory
            [
                'type_id' => 9,
                'key' => 'inventory',
                'data_type' => 'string',
                'description' => 'Name of the inventory to open',
            ],
            [
                'type_id' => 9,
                'key' => 'plugin',
                'data_type' => 'string',
                'description' => 'Name of the plugin that provides the inventory',
            ],
            [
                'type_id' => 9,
                'key' => 'page',
                'data_type' => 'integer',
                'description' => 'Page integer of the inventory',
            ],
            [
                'type_id' => 9,
                'key' => 'arguments',
                'data_type' => 'string',
                'description' => 'Arguments for the inventory',
            ],

            // connect
            [
                'type_id' => 10,
                'key' => 'server',
                'data_type' => 'string',
                'description' => 'Name of the server to connect to',
            ],

            // sound
            [
                'type_id' => 11,
                'key' => 'sound',
                'data_type' => 'string',
                'description' => 'Sound to play using XSound',
            ],
            [
                'type_id' => 11,
                'key' => 'pitch',
                'data_type' => 'integer',
                'value' => '1.0',
                'description' => 'Pitch of the sound',
            ],
            [
                'type_id' => 11,
                'key' => 'volume',
                'data_type' => 'integer',
                'value' => '1.0',
                'description' => 'Volume of the sound',
            ],

            // broadcast_sound
            [
                'type_id' => 12,
                'key' => 'sound',
                'data_type' => 'string',
                'description' => 'Sound to broadcast using XSound',
            ],
            [
                'type_id' => 12,
                'key' => 'pitch',
                'data_type' => 'integer',
                'value' => '1.0',
                'description' => 'Pitch of the sound',
            ],
            [
                'type_id' => 12,
                'key' => 'volume',
                'data_type' => 'integer',
                'value' => '1.0',
                'description' => 'Volume of the sound',
            ],

            // data
            [
                'type_id' => 13,
                'key' => 'action',
                'data_type' => 'string',
                'description' => 'Action to perform on player data (SET/REMOVE/ADD/SUBTRACT)',
            ],
            [
                'type_id' => 13,
                'key' => 'key',
                'data_type' => 'string',
                'description' => 'Data key to update',
            ],
            [
                'type_id' => 13,
                'key' => 'value',
                'data_type' => 'string',
                'description' => 'Value to set for the data key',
            ],
            [
                'type_id' => 13,
                'key' => 'seconds',
                'data_type' => 'integer',
                'value' => '0',
                'description' => 'Expiration time in seconds',
            ],

            // refresh
            /*[
                'type_id' => 14,
                'key' => 'action',
                'data_type' => 'string',
                'description' => 'Refresh the current button',
            ],*/

            // back
            /*[
                'type_id' => 15,
                'key' => 'action',
                'data_type' => 'string',
                'description' => 'Return to the previous inventory',
            ],*/

            // shopkeeper
            [
                'type_id' => 16,
                'key' => 'name',
                'data_type' => 'string',
                'description' => 'Name of the Shopkeeper inventory to open',
            ],

            // book
            [
                'type_id' => 17,
                'key' => 'author',
                'data_type' => 'string',
                'description' => 'Author of the book',
            ],
            [
                'type_id' => 17,
                'key' => 'title',
                'data_type' => 'string',
                'description' => 'Title of the book',
            ],
            [
                'type_id' => 17,
                'key' => 'lines',
                'data_type' => 'textarea',
                'description' => 'Content of the book pages',
            ],

            // actionbar
            [
                'type_id' => 18,
                'key' => 'message',
                'data_type' => 'string',
                'description' => 'Message to display in the action bar',
            ],
            [
                'type_id' => 18,
                'key' => 'mini-message',
                'data_type' => 'bool',
                'value' => 'true',
                'description' => 'Enable MiniMessage format if supported',
            ],

            // withdraw
            [
                'type_id' => 19,
                'key' => 'amount',
                'data_type' => 'integer',
                'description' => 'Amount to withdraw from the player\'s account',
            ],
            [
                'type_id' => 19,
                'key' => 'currency',
                'data_type' => 'string',
                'description' => 'Name of the currency to withdraw',
            ],
            [
                'type_id' => 19,
                'key' => 'economy',
                'data_type' => 'string',
                'description' => 'Name of the economy plugin (if required)',
            ],

            // deposit
            [
                'type_id' => 20,
                'key' => 'amount',
                'data_type' => 'integer',
                'description' => 'Amount to deposit to the player\'s account',
            ],
            [
                'type_id' => 20,
                'key' => 'currency',
                'data_type' => 'string',
                'description' => 'Name of the currency to deposit',
            ],
            [
                'type_id' => 20,
                'key' => 'economy',
                'data_type' => 'string',
                'description' => 'Name of the economy plugin (if required)',
            ],

            // title
            [
                'type_id' => 21,
                'key' => 'title',
                'data_type' => 'string',
                'description' => 'Title to display',
            ],
            [
                'type_id' => 21,
                'key' => 'subtitle',
                'data_type' => 'string',
                'description' => 'Subtitle to display',
            ],
            [
                'type_id' => 21,
                'key' => 'start',
                'data_type' => 'integer',
                'description' => 'Start time in milliseconds',
            ],
            [
                'type_id' => 21,
                'key' => 'duration',
                'data_type' => 'integer',
                'description' => 'Duration in milliseconds',
            ],
            [
                'type_id' => 21,
                'key' => 'end',
                'data_type' => 'integer',
                'description' => 'End time in milliseconds',
            ],

            // teleport
            [
                'type_id' => 22,
                'key' => 'world',
                'data_type' => 'string',
                'description' => 'Name of the world to teleport to',
                'value' => 'world',
            ],
            [
                'type_id' => 22,
                'key' => 'x',
                'data_type' => 'float',
                'description' => 'X coordinate',
            ],
            [
                'type_id' => 22,
                'key' => 'y',
                'data_type' => 'float',
                'description' => 'Y coordinate',
            ],
            [
                'type_id' => 22,
                'key' => 'z',
                'data_type' => 'float',
                'description' => 'Z coordinate',
            ],
            [
                'type_id' => 22,
                'key' => 'yaw',
                'data_type' => 'float',
                'description' => 'Yaw rotation',
                'value' => '0',
            ],
            [
                'type_id' => 22,
                'key' => 'pitch',
                'data_type' => 'float',
                'description' => 'Pitch rotation',
                'value' => '0',
            ],
        ];

        foreach ($actionTypeContents as $content) {
            ActionTypeContent::create($content);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_action_type_contents');
    }
};
