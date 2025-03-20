<?php

namespace App\Jobs;

use App\Models\Builder\InventoryButton;
use App\Models\Builder\InventoryButtonAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateInventoryButtonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $buttonID;

    /**
     * Create a new job instance.
     */
    public function __construct(int $buttonID)
    {
        $this->buttonID = $buttonID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $button = InventoryButton::find($this->buttonID);
        if ($button) {

            if ($button->messages) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 5,
                    'data' => json_encode([
                        'messages' => $button->messages,
                        'mini-message' => true,
                    ]),
                ]);
            }
            if ($button->console_commands) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 3,
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
                        'command-in-chat' => false,
                    ]),
                ]);
            }
            if ($button->sound) {
                InventoryButtonAction::create([
                    'inventory_button_id' => $button->id,
                    'inventory_action_type_id' => 11,
                    'data' => json_encode([
                        'sound' => $button->sound,
                        'pitch' => $button->pitch ?? 1.0,
                        'volume' => $button->volume ?? 1.0,
                    ]),
                ]);
            }

        }
    }
}
