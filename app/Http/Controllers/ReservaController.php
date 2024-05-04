<?php

namespace App\Http\Controllers;

use App\Models\Acontecimiento;
use App\Models\Grupo_Materia;
use App\Models\horario;
use App\Models\Materia;
use App\Models\Reserva;
use App\Models\Mensaje;
use App\Models\Ambiente;
use App\Models\mensajeListener;
use App\Events\mensajeEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index()
{
    // Acontecimientos necesarios
    $acontecimientos = Acontecimiento::all();
  
    // Nombre del usuario actualmente autenticado
    $userName = Auth::user()->name;
  
    // Consulta SQL para obtener las materias y grupos del usuario
    $result = DB::select("
        SELECT u.name AS nombre_usuario, 
               GROUP_CONCAT(DISTINCT m.nombre) AS materias,
               GROUP_CONCAT(DISTINCT g.grupo) AS grupos
        FROM usuario_materias um 
        JOIN users u ON um.id_user = u.id 
        JOIN materias m ON um.id_grupo_materia = m.id 
        JOIN grupos g ON um.id_grupo_materia = g.id 
        WHERE u.name = :userName 
        GROUP BY u.name;
    ", ['userName' => $userName]);
  
    // Verificar si se obtuvieron resultados
    if (!empty($result)) {
        $materias = explode(',', $result[0]->materias);
        $grupos = explode(',', $result[0]->grupos);
    } else {
        $materias = [];
        $grupos = [];
    }
    $horarios = horario::all();
    $Ambientes = ambiente::all();
    return view('Docente.reserva', compact('Ambientes','materias', 'acontecimientos', 'grupos','horarios'));
}
public function getGrupos(Request $request)
{
    $nombreMateria = $request->input('nombre_materia');

    $idMateria = Materia::where('nombre', $nombreMateria)->value('id');

    $gruposMateria = Grupo_Materia::where('id_materia', $idMateria)->get();

    $grupos = $gruposMateria->map(function ($grupoMateria) {
        return $grupoMateria->grupo->grupo;
    });

    return response()->json($grupos);
}

public function guardarSolicitud(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'capacidad' => 'required|numeric',
        'fecha' => 'required|date',
        'motivo' => 'required',
        'horario' => 'required|array',
    ]);
    $id_usuario = Auth::id();
    $horariosSeleccionados = $request->input('horario');
    foreach ($horariosSeleccionados as $horario) {
        $reserva = new Reserva();
        $reserva->capacidad = $request->input('capacidad');
        $reserva->fecha_reserva = $request->input('fecha');
        $reserva->id_usuario_materia = $id_usuario;
        $reserva->id_acontecimiento = $request->input('motivo');
        $reserva->id_horario = $horario;
        $reserva->save();
    }
    $mensaje = new mensajeController();
    $mensaje->enviarSolicitud($request);
    return redirect()->route('docente');
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        //
    }
}
