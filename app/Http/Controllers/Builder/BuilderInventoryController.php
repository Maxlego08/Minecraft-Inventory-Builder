<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\ButtonType;
use App\Models\Builder\Folder;
use App\Models\Builder\Inventory;
use App\Models\Builder\InventoryButton;
use App\Models\Builder\Item;
use App\Models\MinecraftVersion;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BuilderInventoryController extends Controller
{

    /**
     * Récupérer la liste des inventaires d'un dossier
     *
     * @param Folder $folder
     * @return bool|string
     */
    public function inventories(Folder $folder): bool|string
    {

        $user = user();
        if ($folder->user_id != $user->id && !$user->isAdmin()) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot use this folder.', 5000)
            ]);
        }

        $inventories = Inventory::where('folder_id', $folder->id)->get();
        return json_encode([
            'result' => 'success',
            'inventories' => $inventories,
        ]);
    }

    /**
     * Permet de créer un inventaire
     *
     * @param Request $request
     * @param Folder $folder
     * @return string
     */
    public function create(Request $request, Folder $folder): string
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:500|min:0',
            'file_name' => 'required|string|max:100|min:3',
            'size' => 'required|integer',
            'update_interval' => 'required|integer',
            'clear_inventory' => 'required'
        ]);

        $user = user();
        if ($folder->user_id != $user->id && !$user->isAdmin()) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot use this folder.', 5000)
            ]);
        }

        $counts = Inventory::where('user_id', $user->id)->count();
        if ($counts >= $user->role->max_inventories) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'You cannot create a new inventory, please upgrade your account.', 5000)
            ]);
        }

        if ($validatedData['size'] % 9 != 0) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Error with your inventory size.', 5000)
            ]);
        }

        $inventory = Inventory::create([
            'name' => $validatedData['name'],
            'file_name' => $validatedData['file_name'],
            'size' => $validatedData['size'],
            'update_interval' => $validatedData['update_interval'],
            'clear_inventory' => $validatedData['name'] === 'true',
            'user_id' => $user->id,
            'folder_id' => $folder->id,
        ]);
        userLog("Vient de créer l'inventaire $inventory->file_name.$inventory->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return json_encode([
            'result' => 'success',
            'inventory' => $inventory,
            'toast' => createToast('success', 'Success', 'InventoryBuilder successfully created.', 5000)
        ]);
    }

    /**
     * Permet de modifier un inventaire
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return bool|string
     */
    public function update(Request $request, Inventory $inventory): bool|string
    {

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:500|min:0',
            'file_name' => 'required|string|max:100|min:3',
            'size' => 'required|integer',
            'update_interval' => 'required|integer',
            'clear_inventory' => 'required'
        ]);

        $user = user();
        if ($inventory->user_id != $user->id && !$user->isAdmin()) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot use this inventory.', 5000)
            ]);
        }

        $inventory->update([
            'name' => $validatedData['name'],
            'file_name' => $validatedData['file_name'],
            'size' => $validatedData['size'],
            'update_interval' => $validatedData['update_interval'],
            'clear_inventory' => $validatedData['name'] === 'true',
        ]);

        $this->updateButton($request, $inventory);

        userLog("Vient de créer de modifier l'inventaire $inventory->file_name.$inventory->id", UserLog::COLOR_SUCCESS, UserLog::ICON_EDIT);

        return json_encode(['result' => 'success']);

    }

    /**
     * Permet de mettre à jour les boutons de l'inventaire
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return void
     */
    private function updateButton(Request $request, Inventory $inventory): void
    {


        $itemIds = array_column($request['slot'], 'item_id');
        $itemIds = array_unique(array_filter($itemIds));

        $items = Item::findMany($itemIds)->keyBy('id');

        $slotsToKeep = array_filter(array_column($request['slot'], 'slot'), function ($value) {
            return ($value !== null && $value !== false);
        });

        foreach ($request['slot'] as $slot) {
            if (empty($slot) || !isset($items[$slot['item_id']])) continue;

            $currentSlot = $slot['slot'];
            $itemId = $slot['item_id'];

            $name = Str::limit($slot['name'], 255);
            $name = empty($name) ? "btn-$currentSlot" : str_replace(" ", "_", $name);

            $item = $items[$itemId];

            $display_name = isset($slot['display_name']) && $slot['display_name'] !== "null" && trim($slot['display_name']) !== "" ? $slot['display_name'] : null;
            $lore = isset($slot['lore']) && $slot['lore'] !== "null" && trim($slot['lore']) !== "" ? $slot['lore'] : null;

            InventoryButton::updateOrCreate(
                ['inventory_id' => $inventory->id, 'slot' => $currentSlot],
                [
                    'item_id' => $item->id,
                    'amount' => max(1, min(64, $slot['amount'])),
                    'type_id' => 1,
                    'name' => $name,
                    'display_name' => Str::limit($display_name, 65535),
                    'lore' => Str::limit($lore, 65535),
                    'is_permanent' => $this->getBoolean($slot, 'is_permanent'),
                    'close_inventory' => $this->getBoolean($slot, 'close_inventory'),
                    'refresh_on_click' => $this->getBoolean($slot, 'refresh_on_click'),
                    'update_on_click' => $this->getBoolean($slot, 'update_on_click'),
                    'update' => $this->getBoolean($slot, 'update'),
                    'glow' => $this->getBoolean($slot, 'glow'),
                    'model_id' => $slot['model_id']
                ]
            );

        }

        InventoryButton::where('inventory_id', $inventory->id)->whereNotIn('slot', $slotsToKeep)->delete();
    }

    /**
     * Edit an inventory
     *
     * @param Inventory $inventory
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function edit(Inventory $inventory): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $versions = MinecraftVersion::all();
        $inventory = $inventory->load('buttons');
        $inventory = $inventory->load('buttons.item');
        $buttonTypes = ButtonType::all();

        return view('builder.inventory', [
            'inventory' => $inventory,
            'versions' => $versions,
            'buttonTypes' => $buttonTypes,
        ]);
    }

    function getBoolean($array, $key, $defaultValue = false) {

        if (!isset($array[$key])) return $defaultValue;

        $value = strtolower($array[$key]);
        if ($value == 'true') {
            return true;
        } elseif ($value == 'false') {
            return false;
        }

        return $defaultValue;
    }

    /**
     * Permet de renommer un inventaire
     *
     * @param Request $request
     * @param Inventory $inventory
     * @return bool|string
     */
    public function rename(Request $request, Inventory $inventory): bool|string
    {

        $validatedData = $request->validate([
            'file_name' => 'required|string|max:100|min:3',
        ]);

        $user = user();
        if ($inventory->user_id != $user->id && !$user->isAdmin()) {
            return json_encode([
                'result' => 'error',
                'toast' => createToast('error', 'Error', 'Cannot use this folder.', 5000)
            ]);
        }

        userLog("Vient de créer de renommer l'inventaire $inventory->file_name.$inventory->id", UserLog::COLOR_SUCCESS, UserLog::ICON_EDIT);

        return json_encode([
            'result' => 'success',
            'toast' => createToast('success', 'Success', 'Inventory successfully renamed.', 5000)
        ]);

    }

}
