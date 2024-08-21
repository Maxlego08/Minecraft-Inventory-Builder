<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\Builder\Item;

class BuilderItemsController extends Controller
{

    /**
     * Get all items
     *
     * @return bool|string
     */
    public function items(): bool|string
    {
        $items = Item::with('version')->get();
        return json_encode([
            'items' => $items
        ]);
    }
}
