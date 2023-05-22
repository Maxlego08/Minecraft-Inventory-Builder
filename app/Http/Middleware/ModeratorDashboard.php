<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class ModeratorDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = user();
        if (!$user->role->isModerator()) {
            return Redirect::route('home')->with('toast', createToast('error', 'Error', "You dont have permission.", 5000));
        }
        return $next($request);
    }
}
