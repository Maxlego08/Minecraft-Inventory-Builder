<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuilderInventoryController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer',
            'updateInterval' => 'required|integer',
            'clearInventory' => 'required|boolean'
        ]);

        $inventory = Inventory::create($validatedData);

        return response()->json(['success' => 'Inventory created successfully', 'inventory' => $inventory]);
    }
}
