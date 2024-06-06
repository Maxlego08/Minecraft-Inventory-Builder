<?php

namespace App\Http\Controllers;

use App\Models\Resource\Resource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SubscriptionController extends Controller
{
    /**
     * Afficher la page des abonnements
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $resources = Resource::where('subscription', true)->get();
        return view('subscription.index', [
            'resources' => $resources,
        ]);
    }
}
