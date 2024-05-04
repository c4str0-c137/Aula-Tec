<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Autenticación exitosa
        $user = Auth::user();

        // Verificar el rol del usuario
        if ($user->id_rol === 1) { 
            return redirect()->intended('/home');
        } elseif ($user->id_rol === 2) {
            return redirect()->route('docente');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No tienes permiso para acceder a esta página.');
        }
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ]);
}


}