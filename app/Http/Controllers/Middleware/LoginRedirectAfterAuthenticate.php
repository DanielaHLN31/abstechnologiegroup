<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;


class LoginRedirectAfterAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            // Si l'utilisateur est déjà authentifié, redirigez-le vers le tableau de bord
            return redirect()->route('dashboardVendors');
        }

        // Si l'utilisateur n'est pas authentifié, laissez la requête suivre son cours normal
        return $next($request);
    }
}
