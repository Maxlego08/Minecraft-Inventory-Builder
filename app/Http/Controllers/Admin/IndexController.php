<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Folder;
use App\Models\Builder\Inventory;
use App\Models\Payment\Payment;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Utils\Charts;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * First page of dashboard
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $payments = Payment::where('status', Payment::STATUS_PAID)->sum('price');
        return view('admins.dashboard', [
            'users' => User::count(),
            'resources' => Resource::count(),
            'folders' => Folder::count(),
            'inventories' => Inventory::count(),
            'payments' => $payments,
            'newUsersPerMonths' => Charts::countByMonths(User::query()),
            'newUsersPerDays' => Charts::countByDays(User::query(), null, 14),
        ]);
    }
}
