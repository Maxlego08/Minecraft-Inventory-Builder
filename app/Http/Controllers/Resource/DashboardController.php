<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{

    /**
     * Afficher le dashboard de l'utilisateur
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = user();
        $currency = $user->paymentInfo?->currency ?? 'eur';
        $resources = $user->resources->count();
        $payments = Payment::select('payment_payments.*')
            ->join('resource_resources', 'payment_payments.content_id', '=', 'resource_resources.id')
            ->where('resource_resources.user_id', $user->id) // L'identifiant de l'utilisateur qui possède la ressource
            ->where('payment_payments.type', Payment::TYPE_RESOURCE) // Assurez-vous que le type de paiement est pour les ressources
            ->where('payment_payments.status', Payment::STATUS_PAID) // Vous pouvez ajuster ce critère en fonction de vos besoins
            ->get();

        $earnMoney = $payments->sum('price');

        return view('resources.dashboard.index', [
            'currency' => $currency,
            'download' => 0,
            'payments' => $payments->count(),
            'resources' => $resources,
            'earnMoney' => $earnMoney
        ]);
    }

    /**
     * Afficher les paiements de l'utilisateur
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function payments(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('resources.dashboard.payments');
    }

    /**
     * Afficher les resources de l'utilisateur
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function resources(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resources = ResourcePagination::paginateAuthor(user());
        return view('resources.dashboard.resources', [
            'resources_count' => $resources->total(),
            'resources' => $resources,
        ]);
    }
}
