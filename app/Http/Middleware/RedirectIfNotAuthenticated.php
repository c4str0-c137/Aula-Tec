<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Guardar la URL original
            session(['url.intended' => $request->fullUrl()]);

            // Redirigir al login
            return redirect()->route('login')->withErrors(['message' => 'Por favor, inicia sesión para continuar.']);
        }

        return $next($request);
    }
}
