<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class InventoryController extends Controller
{
    /**
     * Page principale des inventaires
     *
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     */
    public function index(): Factory|\Illuminate\Foundation\Application|View|Application
    {

        $inventories = Inventory::with('user')->with('folder')->paginate();

        return view('admins.inventories.index', [
            'inventories' => $inventories,
        ]);

    }
}
