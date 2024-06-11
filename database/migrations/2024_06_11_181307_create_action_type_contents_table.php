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
            $table->timestamps();
        });

        ActionTypeContent::create([
            'type_id' => 1,
            'key' => 'commands',
            'data_type' => 'textarea',
            'description' => 'Commands that the player must perform'
        ]);
        ActionTypeContent::create([
            'type_id' => 1,
            'key' => 'commandInChat',
            'data_type' => 'bool',
            'description' => 'Allows to execute commands in chat'
        ]);

        ActionTypeContent::create([
            'type_id' => 2,
            'key' => 'commands',
            'data_type' => 'array',
            'description' => 'Commands that the console must perform'
        ]);

        ActionTypeContent::create([
            'type_id' => 3,
            'key' => 'messages',
            'data_type' => 'array',
            'description' => 'Messages to be displayed'
        ]);
        ActionTypeContent::create([
            'type_id' => 3,
            'key' => 'minimessage',
            'data_type' => 'bool',
            'description' => 'Indicates if the message is a mini message'
        ]);

        ActionTypeContent::create([
            'type_id' => 4,
            'key' => 'messages',
            'data_type' => 'array',
            'description' => 'Broadcast messages to be displayed'
        ]);
        ActionTypeContent::create([
            'type_id' => 4,
            'key' => 'minimessage',
            'data_type' => 'bool',
            'description' => 'Indicates if the broadcast message is a mini message'
        ]);

        ActionTypeContent::create([
            'type_id' => 5,
            'key' => 'messages',
            'data_type' => 'array',
            'description' => 'Chat messages to be displayed'
        ]);

        ActionTypeContent::create([
            'type_id' => 7,
            'key' => 'inventory',
            'data_type' => 'string',
            'description' => 'Name of the inventory'
        ]);
        ActionTypeContent::create([
            'type_id' => 7,
            'key' => 'plugin',
            'data_type' => 'string',
            'description' => 'Name of the plugin'
        ]);
        ActionTypeContent::create([
            'type_id' => 7,
            'key' => 'page',
            'data_type' => 'integer',
            'description' => 'Page number'
        ]);
        ActionTypeContent::create([
            'type_id' => 7,
            'key' => 'arguments',
            'data_type' => 'array',
            'description' => 'List of arguments'
        ]);

        ActionTypeContent::create([
            'type_id' => 8,
            'key' => 'server',
            'data_type' => 'string',
            'description' => 'Name of the server to connect to'
        ]);

        ActionTypeContent::create([
            'type_id' => 9,
            'key' => 'sound',
            'data_type' => 'string',
            'description' => 'Name of the sound to be played'
        ]);
        ActionTypeContent::create([
            'type_id' => 9,
            'key' => 'pitch',
            'data_type' => 'float',
            'description' => 'Pitch of the sound (default is 1.0f)'
        ]);
        ActionTypeContent::create([
            'type_id' => 9,
            'key' => 'volume',
            'data_type' => 'float',
            'description' => 'Volume of the sound (default is 1.0f)'
        ]);

        ActionTypeContent::create([
            'type_id' => 10,
            'key' => 'sound',
            'data_type' => 'string',
            'description' => 'Name of the sound to be broadcasted'
        ]);
        ActionTypeContent::create([
            'type_id' => 10,
            'key' => 'pitch',
            'data_type' => 'float',
            'description' => 'Pitch of the broadcasted sound (default is 1.0f)'
        ]);
        ActionTypeContent::create([
            'type_id' => 10,
            'key' => 'volume',
            'data_type' => 'float',
            'description' => 'Volume of the broadcasted sound (default is 1.0f)'
        ]);

        ActionTypeContent::create([
            'type_id' => 11,
            'key' => 'action',
            'data_type' => 'string',
            'description' => 'Action to be performed (SET/REMOVE/ADD/SUBTRACT)'
        ]);
        ActionTypeContent::create([
            'type_id' => 11,
            'key' => 'key',
            'data_type' => 'string',
            'description' => 'Key of the data'
        ]);
        ActionTypeContent::create([
            'type_id' => 11,
            'key' => 'value',
            'data_type' => 'string',
            'description' => 'Value of the data'
        ]);
        ActionTypeContent::create([
            'type_id' => 11,
            'key' => 'seconds',
            'data_type' => 'integer',
            'description' => 'Expiration time in seconds (default is 0)'
        ]);

        ActionTypeContent::create([
            'type_id' => 14,
            'key' => 'name',
            'data_type' => 'string',
            'description' => 'Name of the shopkeeper'
        ]);

        ActionTypeContent::create([
            'type_id' => 15,
            'key' => 'author',
            'data_type' => 'string',
            'description' => 'Book author'
        ]);
        ActionTypeContent::create([
            'type_id' => 15,
            'key' => 'title',
            'data_type' => 'string',
            'description' => 'Book title'
        ]);
        ActionTypeContent::create([
            'type_id' => 15,
            'key' => 'lines',
            'data_type' => 'array',
            'description' => 'Book pages'
        ]);

        ActionTypeContent::create([
            'type_id' => 16,
            'key' => 'message',
            'data_type' => 'string',
            'description' => 'Message to be displayed in the action bar'
        ]);
        ActionTypeContent::create([
            'type_id' => 16,
            'key' => 'minimessage',
            'data_type' => 'bool',
            'description' => 'Indicates if the message is a mini message'
        ]);


        ActionTypeContent::create([
            'type_id' => 17,
            'key' => 'amount',
            'data_type' => 'integer',
            'description' => 'Amount to withdraw'
        ]);

        ActionTypeContent::create([
            'type_id' => 18,
            'key' => 'amount',
            'data_type' => 'integer',
            'description' => 'Amount to deposit'
        ]);



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_action_type_contents');
    }
};
