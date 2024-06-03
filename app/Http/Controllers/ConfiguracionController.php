<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{

public function index()
{
    $configuracion = Configuracion::first();
    return view('Configuracion.index', compact('configuracion'));
}

public function guardarConfiguracion(Request $request)
{
    // Validar los datos del formulario si es necesario
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date',
        'cantidad_periodos' => 'required|integer|min:1',
    ]);

    // Actualizar la configuración en la base de datos
    $configuracion = Configuracion::first();

    if (!$configuracion) {
        $configuracion = new Configuracion();
    }
    $configuracion->fecha_inicio = $request->fecha_inicio;
    $configuracion->fecha_fin = $request->fecha_fin;
    $configuracion->periodos = $request->cantidad_periodos;
    $configuracion->save();

    // Redireccionar o devolver una respuesta según sea necesario
    return redirect()->back()->with('success', 'Configuración guardada exitosamente');
}


}
