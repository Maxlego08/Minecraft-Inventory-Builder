<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Resource\ResourcePagination;
use App\Models\Builder\Inventory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class BuilderMarketplaceController extends Controller
{

    /**
     * View public inventories
     *
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     */
    public function inventories(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $inventories = Inventory::with('user')->where('inventory_visibility_id', 3)->orderBy('created_at')->paginate(30);
        $mostInventories = ResourcePagination::mostInventoriesPagination();
        return view('builder.inventories', [
            'inventories' => $inventories,
            'mostInventories' => $mostInventories,
        ]);

    }
}
