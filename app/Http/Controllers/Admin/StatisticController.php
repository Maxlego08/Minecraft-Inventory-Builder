<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class StatisticController extends Controller
{

    /**
     * Displays statistics
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $inventories = Inventory::count();
        $inventoriesWithButtons = Inventory::whereHas('buttons')->count();
        return view('admins.statistic.index', [
            'inventories' => $inventories,
            'inventoriesWithButtons' => $inventoriesWithButtons,
        ]);
    }
}
