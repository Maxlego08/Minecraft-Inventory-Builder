<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class Moderator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guest()) {
            $user = user();
            if (!$user->role->isModerator()) {
                return Redirect::route('home')->with('toast', createToast('error', 'Erreur', "You do not have permission to do this", 5000));
            }
        }
        return $next($request);
    }
}
