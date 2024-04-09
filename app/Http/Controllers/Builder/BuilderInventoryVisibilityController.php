<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use App\Models\Builder\InventoryVisibility;
use App\Models\UserLog;

class BuilderInventoryVisibilityController extends Controller
{
    public function changeVisibility(Inventory $inventory, InventoryVisibility $inventoryVisibility)
    {
        $user = user();
        if ($inventory->user_id != $user->id && !$user->isAdmin()) {
            abort(403, "You don't have permission");
        }

        $inventory->update(['inventory_visibility_id', $inventoryVisibility->id]);

        userLog("Vient de changer la visibilité de l'inventaire $inventory->file_name.$inventory->id à $inventoryVisibility->name", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return json_encode([
            'result' => 'success',
            'toast' => createToast('success', 'Success', "You just changed the visibility of the inventory", 5000),
        ]);
    }
}
