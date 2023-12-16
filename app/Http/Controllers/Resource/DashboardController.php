<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Resource\Version;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;

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

        $cacheKey = 'dashboard_data_user_' . $user->id;

        $data = Cache::remember($cacheKey, 600, function () use ($user) {
            $currency = $user->paymentInfo?->currency->currency ?? 'eur';
            $resources = $user->resources->count();
            $payments = Payment::select('payment_payments.*')
                ->join('resource_resources', 'payment_payments.content_id', '=', 'resource_resources.id')
                ->where('resource_resources.user_id', $user->id) // L'identifiant de l'utilisateur qui possède la ressource
                ->where('payment_payments.type', Payment::TYPE_RESOURCE) // Assurez-vous que le type de paiement est pour les ressources
                ->where('payment_payments.status', Payment::STATUS_PAID) // Vous pouvez ajuster ce critère en fonction de vos besoins
                ->get();

            $earnMoney = $payments->sum('price');

            $download = Version::join('resource_resources', 'resource_versions.resource_id', '=', 'resource_resources.id')
                ->where('resource_resources.user_id', $user->id) // Filtrer les ressources appartenant à l'utilisateur
                ->sum('resource_versions.download'); // Somme de la colonne `download`
            return [
                'currency' => $currency,
                'download' => $download,
                'payments' => $payments->count(),
                'resources' => $resources,
                'earnMoney' => $earnMoney
            ];
        });


        return view('resources.dashboard.index', $data);
    }

    /**
     * Afficher les paiements de l'utilisateur
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function payments(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $payments = Payment::select('payment_payments.*')
            ->join('resource_resources', 'payment_payments.content_id', '=', 'resource_resources.id')
            ->where('resource_resources.user_id', user()->id) // L'identifiant de l'utilisateur qui possède la ressource
            ->where('payment_payments.type', Payment::TYPE_RESOURCE) // Assurez-vous que le type de paiement est pour les ressources
            ->where('payment_payments.status', Payment::STATUS_PAID) // Filtrer par statut de paiement si nécessaire
            ->orderBy('payment_payments.created_at', 'desc') // Tri par date de création, le plus récent en premier
            ->paginate(30);

        return view('resources.dashboard.payments', [
            'payments' => $payments,
        ]);
    }

    /**
     * Afficher le détail d'un paiement
     *
     * @param Payment $payment
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function paymentDetails(Payment $payment): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $currency = "eur";
        $name = "";
        $gift = $payment->gift;
        $contentPrice = $payment->price;
        $price = $payment->price;
        $giftReduction = 0;
        if ($payment->type == Payment::TYPE_RESOURCE) {
            $resource = $payment->resource;
            $contentPrice = $resource->price;
            $currency = $payment->currency->currency;
            $name = $resource->name;
        }

        if (isset($gift)) {
            $giftReduction = ($contentPrice * $gift->reduction) / 100;
            $price = $contentPrice - $giftReduction;
        }

        return view('resources.dashboard.details', [
            'payment' => $payment,
            'price' => $price,
            'name' => $name,
            'currency' => $currency,
            'gift' => $gift,
            'giftReduction' => $giftReduction,
            'contentPrice' => $contentPrice,
        ]);
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
