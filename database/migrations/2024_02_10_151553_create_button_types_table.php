<?php

use App\Models\Builder\ButtonType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_button_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('addon_id')->constrained('inventory_addons')->onDelete('cascade');
            $table->string('name');
            $table->longText('description');
            $table->longText('example')->nullable();
            $table->timestamps();
        });

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'None',
            'description' => 'default button'
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'Inventory',
            'description' => "Opens a new inventory"
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'Back',
            'description' => "Allows you to return to the previous inventory."
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'Home',
            'description' => "Allows you to return to the main inventory, the one that was opened first."
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'Next',
            'description' => "Allows you to go to the next page if it exists. You can use the else element to display another button if there is no next page.",
            'example' => "next:
  type: NEXT
  isPermanent: true
  slot: 50
  item:
    material: ARROW
    name: '&fNext'
  else: #Displays another button if there is no next page.
    slot: 50
    type: NONE
    isPermanent: true
    item:
      material: BLACK_STAINED_GLASS_PANE",
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'Previous',
            'description' => "Allows you to go to the previous page if it exists. You can use the else element to display another button if there is no previous page.",
            'example' => "next:
  type: PREVIOUS
  isPermanent: true
  slot: 50
  item:
    material: ARROW
    name: '&fPrevious'
  else: #Displays another button if there is no next page.
    slot: 50
    type: NONE
    isPermanent: true
    item:
      material: BLACK_STAINED_GLASS_PANE"
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'MainMenu',
            'description' => "Allows you to returns to the main inventory you chose in the config.json"
        ]);

        ButtonType::create([
            'addon_id' => 1,
            'name' => 'Jump',
            'description' => "Allows to change page, to a predefined page."
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_button_types');
    }
};
