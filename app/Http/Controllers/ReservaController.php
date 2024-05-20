<?php

namespace App\Http\Controllers;

use App\Models\Acontecimiento;
use App\Models\Grupo_Materia;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\Reserva;
use App\Models\Mensaje;
use App\Models\Ambiente;
use App\Models\mensajeListener;
use App\Events\mensajeEvent;
use App\Models\TipoAmbiente;
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
        $userName = Auth::user()->id;
        // Consulta SQL para obtener las materias del usuario
        $materias = DB::select("
        SELECT DISTINCT
                u.id AS id_usuario,
                u.name AS nombre_usuario,
                m.id AS id_materia,
                m.nombre AS nombre_materia
            FROM 
                usuario_materias um  
            JOIN 
                users u ON um.id_user = u.id  
            JOIN 
                grupo_materias mg ON um.id_grupo_materia = mg.id  
            JOIN 
                materias m ON mg.id_materia = m.id  
            WHERE 
                u.id = :userName;
        ", ['userName' => $userName]);
        $horarios = horario::all();
        $Ambientes = ambiente::all();
        $tiposAmbiente = TipoAmbiente::all();
        return view('Docente.reserva', compact('tiposAmbiente', 'materias', 'acontecimientos', 'horarios'));
    }

public function getGrupos(Request $request)
{
    $nombreMateria = $request->input('nombre_materia');
    $idMateria = Materia::where('nombre', $nombreMateria)->value('id');
    $gruposMateria = Grupo_Materia::where('id_materia', $idMateria)->get();
    $grupos = $gruposMateria->map(function ($grupoMateria) {
        return [
            'id' => $grupoMateria->grupo->id,
            'nombre' => $grupoMateria->grupo->grupo
        ];
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
        'tipo_ambiente' => 'required'
    ]);
    $id_usuario = Auth::id();
    $nombreMateria = $request->input('materia');
    $idGrupo = $request->input('grupo');
    // Obtener el ID de la tabla 'grupo_materias' usando el nombre de la materia y el nombre del grupo
    $idMateria      = DB::table("materias")->where("nombre",$nombreMateria)->value('id');
    $idGrupoMateria = DB::table("grupo_materias")->where("id_grupo", $idGrupo)->where('id_materia',$idMateria)->value('id');
    $id_usuario_materia = DB::table("usuario_materias")->where('id_user',$id_usuario)->where('id_grupo_materia',$idGrupoMateria)->value('id');

    $horariosSeleccionados = $request->input('horario');
    foreach ($horariosSeleccionados as $horario) {
        $reserva = new Reserva();
        $reserva->capacidad = $request->input('capacidad');
        $reserva->fecha_reserva = $request->input('fecha');
        $reserva->id_usuario_materia = $id_usuario_materia;
        $reserva->id_acontecimiento = $request->input('motivo');
        $reserva->id_horario = $horario;
        $reserva->id_tipoAmbiente = $request->input('tipo_ambiente');
        $reserva->save();
    }
    $mensaje = new mensajeController();
    $mensaje->enviarSolicitud($request,$id_usuario_materia);
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