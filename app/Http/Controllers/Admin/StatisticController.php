<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Inventory;
use App\Models\User;
use App\Models\UserRole;
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
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $premiums = User::where('user_role_id', 3)->count();
        $pros = User::where('user_role_id', 4)->count();

        return view('admins.statistic.index', [
            'inventories' => $inventories,
            'inventoriesWithButtons' => $inventoriesWithButtons,
            'verifiedUsers' => $verifiedUsers,
            'premiums' => $premiums,
            'pros' => $pros,
        ]);
    }
}
