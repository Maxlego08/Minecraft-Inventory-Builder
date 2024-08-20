<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AdministratorDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = user();
        if (!$user->role->isAdmin()) {
            return Redirect::route('admin.index')->with('toast', createToast('error', 'Error', "You dont have permission.", 5000));
        }
        return $next($request);
    }
}
