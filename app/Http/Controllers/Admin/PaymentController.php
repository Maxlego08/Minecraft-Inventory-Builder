<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Afficher la liste des paiements
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(Request $request): \Illuminate\Foundation\Application|View|Factory|Application
    {

        $search = $request->input('search');
        $payments = Payment::select('payment_payments.*')->when($search, function (Builder $query, string $search) {
            return $query->leftJoin('users', 'payment_payments.user_id', '=', 'users.id')
                ->where(function ($query) use ($search) {
                    $query->where('payment_payments.user_id', 'like', "%{$search}%")
                        ->orWhere('payment_payments.payment_id', 'like', "%{$search}%")
                        ->orWhere('payment_payments.external_id', 'like', "%{$search}%")
                        ->orWhere('payment_payments.status', 'like', "%{$search}%")
                        ->orWhere('payment_payments.type', 'like', "%{$search}%")
                        ->orWhere('payment_payments.gateway', 'like', "%{$search}%")
                        ->orWhere('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%");
                });
        })->orderBy('created_at', 'DESC')->paginate(30);

        return view('admins.payments.index', [
            'payments' => $payments,
            'search' => $search,
        ]);
    }

    /**
     * Afficher les paiements
     *
     * @param Payment $payment
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function show(Payment $payment): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.payments.show', [
            'payment' => $payment,
        ]);
    }

    /**
     * Permet de supprimer les paiements non payés
     *
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        Payment::where('status', Payment::STATUS_UNPAID)->whereRaw('created_at <= ?', [Carbon::now()->subDay()])->delete();
        userLog("Suppression des paiements non payés", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);
        return Redirect::route('admin.payments.index')->with('toast',
            createToast('success', 'Succès', "Suppression des paiements non payés"));
    }
}
