<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::simplePaginate(10);
        return view('admin.users.index', compact('users'));
    }

    
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request ->role);

        return redirect() ->route('users.edit', $user)
                         ->whit('success-update', 'Rol establecido con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->action([UserController::class, 'index'])
                         ->with('success-delete', 'Usuario eliminado con exito');    
    }
    public function create()
{
    // Obtener el usuario autenticado
    $user = Auth::user();

    // Verificar si el usuario tiene materias asociadas
    if ($user->materias !== null && $user->materias->count() > 0) {
        $materias = $user->materias->pluck('nombre', 'id');
    } else {
        // Si el usuario no tiene materias asociadas, asignar un array vacío
        $materias = [];
    }

    // Pasar las materias a la vista
    return view('Docente.reserva', compact('materias'));
}

}
