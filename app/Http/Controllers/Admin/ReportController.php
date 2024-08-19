<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert\AlertUser;
use App\Models\Report;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    /**
     * Afficher les reports en attente de résolution
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function pending(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $reports = Report::whereNull('resolved_at')->get();
        return view('admins.reports.pending', [
            'reports' => $reports
        ]);
    }

    /**
     * Afficher tout les reports
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $reports = Report::orderBy('created_at', 'DESC')->paginate();
        return view('admins.reports.index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Afficher un report
     *
     * @param Report $report
     * @return View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
     */
    public function view(Report $report): View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
    {
        if (isset($report->resolved_at)) {
            return Redirect::route('admin.reports.index');
        }
        return view('admins.reports.resolve', [
            'report' => $report,
        ]);
    }


    /**
     * Résoudre un report
     *
     * @param Request $request
     * @param Report $report
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function resolve(Request $request, Report $report): RedirectResponse
    {
        if (isset($report->resolved_at)) {
            return Redirect::route('admin.reports.index');
        }

        $this->validate($request, [
            'resolution_message' => 'required|string|max:255',
        ]);

        $report->update([
            'resolved_by' => auth()->id(),
            'resolution_message' => $request['resolution_message'],
            'resolved_at' => now(),
        ]);

        userLog("Résolution du report $report->id", UserLog::COLOR_SUCCESS, UserLog::ICON_HEART_BREAK);
        createAlert($report->user_id, $report['resolution_message'], AlertUser::ICON_SUCCESS, AlertUser::SUCCESS, 'alerts.alerts.report');

        Cache::forget('pending_report');

        return Redirect::route('admin.reports.index')->with('toast',
            createToast('success', 'Succès', "Résolution du report $report->id"));
    }

}

