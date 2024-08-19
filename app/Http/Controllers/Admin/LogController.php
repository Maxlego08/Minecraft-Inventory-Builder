<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\UserLog;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display user log
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(Request $request): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $search = $request['search'];

        $logs = UserLog::select('user_logs.*')
            ->join('users', 'users.id', '=', 'user_logs.user_id')
            ->when($search, function ($query, $search) {
                return $query
                    ->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('user_logs.action', 'like', '%' . $search . '%')
                    ->orWhere('user_logs.ipv4', 'like', '%' . $search . '%')
                    ->orWhere('user_logs.icon', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(20);

        return view('admins.logs.index', [
            'search' => $search,
            'logs' => $logs,
        ]);
    }
}
