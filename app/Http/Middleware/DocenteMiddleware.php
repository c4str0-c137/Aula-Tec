<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    if (Auth::check() && Auth::user()->id_rol == 2) {
        return $next($request);
    }
    return redirect()->route('login')->withErrors(['message' => 'Acceso no autorizado.']);    
    }

}
