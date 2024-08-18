<?php

use App\Models\Builder\InventoryButton;
use App\Models\Builder\InventoryButtonAction;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $buttons = InventoryButton::all();
        foreach ($buttons as $button) {
            if ($button->messages) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 3,
                    'data' => json_encode([
                        'messages' => $button->messages,
                        'minimessage' => true,
                    ]),
                ]);
            }
            if ($button->console_commands) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 2,
                    'data' => json_encode([
                        'commands' => $button->console_commands,
                    ]),
                ]);
            }
            if ($button->commands) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 1,
                    'data' => json_encode([
                        'commands' => $button->commands,
                        'commandInChat' => false,
                    ]),
                ]);
            }
            if ($button->sound) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 9,
                    'data' => json_encode([
                        'sound' => $button->sound,
                        'pitch' => $button->pitch ?? 1.0,
                        'volume' => $button->volume ?? 1.0,
                    ]),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
