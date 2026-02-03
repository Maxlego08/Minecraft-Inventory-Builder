<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Folder;
use App\Models\Builder\Inventory;
use App\Models\Payment\Payment;
use App\Models\Report;
use App\Models\Resource\Category;
use App\Models\Resource\Download;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Utils\Charts;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    /**
     * Displays statistics
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // --- Compteurs généraux ---
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $premiums = User::where('user_role_id', 3)->count();
        $pros = User::where('user_role_id', 4)->count();

        $totalResources = Resource::count();
        $pendingResources = Resource::where('is_pending', true)->count();
        $paidResources = Resource::where('price', '>', 0)->count();
        $freeResources = Resource::where('price', 0)->count();

        $totalInventories = Inventory::count();
        $inventoriesWithButtons = Inventory::whereHas('buttons')->count();
        $totalFolders = Folder::count();

        $totalDownloads = Download::count();
        $totalReports = Report::count();
        $openReports = Report::whereNull('resolved_at')->count();

        // --- Paiements ---
        $totalRevenue = Payment::where('status', Payment::STATUS_PAID)->sum('price');
        $totalPayments = Payment::where('status', Payment::STATUS_PAID)->count();
        $refundedPayments = Payment::where('status', Payment::STATUS_REFUND)->count();
        $disputedPayments = Payment::where('status', Payment::STATUS_DISPUTE)->count();

        // --- Graphiques temporels ---
        $usersPerMonth = Charts::countByMonths(User::query());
        $usersPerDay = Charts::countByDays(User::query(), null, 30);

        $inventoriesPerMonth = Charts::countByMonths(Inventory::query());
        $resourcesPerMonth = Charts::countByMonths(Resource::query());
        $downloadsPerMonth = Charts::countByMonths(Download::query());

        $revenuePerMonth = Charts::sumByMonths(
            Payment::where('status', Payment::STATUS_PAID),
            'price'
        );

        $paymentsPerMonth = Charts::countByMonths(
            Payment::where('status', Payment::STATUS_PAID)
        );

        // --- Répartition par type de paiement ---
        $paymentsByType = Payment::where('status', Payment::STATUS_PAID)
            ->select('type', DB::raw('count(*) as total'), DB::raw('sum(price) as revenue'))
            ->groupBy('type')
            ->get()
            ->mapWithKeys(function ($item) {
                $label = match ($item->type) {
                    Payment::TYPE_RESOURCE => 'Ressources',
                    Payment::TYPE_ACCOUNT_UPGRADE => 'Upgrades',
                    Payment::TYPE_NAME_COLOR => 'Couleurs',
                    default => 'Autre',
                };
                return [$label => ['total' => $item->total, 'revenue' => $item->revenue]];
            });

        // --- Répartition par gateway ---
        $paymentsByGateway = Payment::where('status', Payment::STATUS_PAID)
            ->select('gateway', DB::raw('count(*) as total'))
            ->groupBy('gateway')
            ->get()
            ->pluck('total', 'gateway');

        // --- Ressources par catégorie ---
        $resourcesByCategory = Category::withCount('resources')
            ->orderByDesc('resources_count')
            ->get()
            ->pluck('resources_count', 'name');

        return view('admins.statistic.index', [
            // Compteurs
            'totalUsers' => $totalUsers,
            'verifiedUsers' => $verifiedUsers,
            'premiums' => $premiums,
            'pros' => $pros,
            'totalResources' => $totalResources,
            'pendingResources' => $pendingResources,
            'paidResources' => $paidResources,
            'freeResources' => $freeResources,
            'totalInventories' => $totalInventories,
            'inventoriesWithButtons' => $inventoriesWithButtons,
            'totalFolders' => $totalFolders,
            'totalDownloads' => $totalDownloads,
            'totalReports' => $totalReports,
            'openReports' => $openReports,
            'totalRevenue' => $totalRevenue,
            'totalPayments' => $totalPayments,
            'refundedPayments' => $refundedPayments,
            'disputedPayments' => $disputedPayments,
            // Graphiques
            'usersPerMonth' => $usersPerMonth,
            'usersPerDay' => $usersPerDay,
            'inventoriesPerMonth' => $inventoriesPerMonth,
            'resourcesPerMonth' => $resourcesPerMonth,
            'downloadsPerMonth' => $downloadsPerMonth,
            'revenuePerMonth' => $revenuePerMonth,
            'paymentsPerMonth' => $paymentsPerMonth,
            // Répartitions
            'paymentsByType' => $paymentsByType,
            'paymentsByGateway' => $paymentsByGateway,
            'resourcesByCategory' => $resourcesByCategory,
        ]);
    }
}
