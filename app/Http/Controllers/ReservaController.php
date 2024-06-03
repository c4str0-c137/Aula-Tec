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
use App\Models\Configuracion;
use App\Models\TipoAmbiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;


class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $cantidadPeriodos = Configuracion::first();
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

        // Pasar la variable $cantidadPeriodos a la vista
        return view('Docente.reserva', compact('tiposAmbiente', 'materias', 'acontecimientos', 'horarios', 'cantidadPeriodos',));
    }
    public function confirmarSolicitud(Request $request,$id, $action )
    {
        // Verifica si el ID es un rango
        if (strpos($id, '-') !== false) {
            // Si es un rango, obtén el rango de IDs
            list($start, $end) = explode('-', $id);
            $ids = range($start, $end);
        } else {
            // Si no es un rango, simplemente agrega el ID
            $ids = [$id];
        }

        // Itera sobre cada ID en el rango y actualiza su estado
        $ambientes = $request->input('ambientes');
        foreach ($ids as $reservaId) {
            $reserva = Reserva::findOrFail($reservaId);

            // Verifica la acción a realizar
            if ($action === 'confirmar') {
                // Cambia el estado de la reserva a confirmado
                $reserva->update(['estado' => 'confirmado']);
                $estadoUpdate = 2;
            } elseif ($action === 'rechazar') {
                // Cambia el estado de la reserva a rechazado
                $reserva->update(['estado' => 'rechazado']);
                $estadoUpdate = 1;
            }
            foreach ($ambientes as $ambiente) {
                $this->activarAula($ambiente, $reserva->fecha_reserva, $reserva->id_horario,$estadoUpdate);            
            }
        }

        return view('Docente.docente');
    }

    private function activarAula($ambiente, $fecha_reserva, $id_horario, $estadoUpdate)
    {
        // Obtener el ID del ambiente
        $aula = DB::table('ambientes')
            ->where('numeroaula', $ambiente)
            ->first(['id']);
    
        // Obtener el día de la semana en español
        $dayOfWeek = (new DateTime($fecha_reserva))->format('l');
        $diasSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        $diaSemanaEsp = $diasSemana[$dayOfWeek];
    
        // Obtener el ID del día en la tabla "dias"
        $dia = DB::table('dias')
            ->where('nombre', $diaSemanaEsp)
            ->value('id');
    
        // Obtener el ID del ambiente
        $aulaId = $aula->id;
    
        // Actualizar el estado del ambiente_horario a "activo" (1)
        $updated = DB::table('ambiente_horarios')
            ->where('id_ambiente', $aulaId)
            ->where('id_horario', $id_horario)
            ->where('id_dia', $dia)
            ->update(['id_estado_horario' => $estadoUpdate]); // Cambia esto según tu esquema de base de datos
    }
    
    public function showPendientes()
    {
        // Obtener las reservas con estado "pendiente"
        $reservas = DB::table('reservas')
            ->where('estado', 'pendiente')
            ->get();

        // Obtener los IDs de usuario_materia y horario
        $usuarioMateriaIds = $reservas->pluck('id_usuario_materia')->unique();
        $horarioIds = $reservas->pluck('id_horario')->unique();

        // Obtener la información de usuario_materias y horarios
        $usuarioMaterias = DB::table('usuario_materias')
            ->whereIn('id', $usuarioMateriaIds)
            ->get();

        $horarios = DB::table('horarios')
            ->whereIn('id', $horarioIds)
            ->get();

        // Obtener los IDs de usuarios y grupo_materias
        $userIds = $usuarioMaterias->pluck('id_user')->unique();
        $grupoMateriaIds = $usuarioMaterias->pluck('id_grupo_materia')->unique();

        // Obtener la información de los usuarios
        $users = DB::table('users')
            ->whereIn('id', $userIds)
            ->get();

        // Obtener la información de grupo_materias
        $grupoMaterias = DB::table('grupo_materias')
            ->whereIn('id', $grupoMateriaIds)
            ->get();

        // Obtener los IDs de materias y grupos
        $materiaIds = $grupoMaterias->pluck('id_materia')->unique();
        $grupoIds = $grupoMaterias->pluck('id_grupo')->unique();

        // Obtener la información de materias y grupos
        $materias = DB::table('materias')
            ->whereIn('id', $materiaIds)
            ->get();

        $grupos = DB::table('grupos')
            ->whereIn('id', $grupoIds)
            ->get();

        // Combinar los datos
        $reservas = $reservas->map(function ($reserva) use ($usuarioMaterias, $users, $grupoMaterias, $materias, $grupos, $horarios) {
            $usuarioMateria = $usuarioMaterias->firstWhere('id', $reserva->id_usuario_materia);
            $user = $users->firstWhere('id', $usuarioMateria->id_user);
            $grupoMateria = $grupoMaterias->firstWhere('id', $usuarioMateria->id_grupo_materia);
            $materia = $materias->firstWhere('id', $grupoMateria->id_materia);
            $grupo = $grupos->firstWhere('id', $grupoMateria->id_grupo);

            // Obtener el horario correspondiente
            $horario = $horarios->firstWhere('id', $reserva->id_horario);

            return (object) [
                'id' => $reserva->id,
                'fecha_reserva' => $reserva->fecha_reserva,
                'docente' => $user->name ?? 'N/A',
                'materia' => $materia->nombre ?? 'N/A',
                'grupo' => $grupo->grupo ?? 'N/A',
                'horario' => $horario ? "{$horario->horaini} - {$horario->horafin}" : 'N/A',
                'estado' => $reserva->estado
            ];
        });
        //dd($reservas);
        // Retornar la vista con las reservas
        return view('mensaje.pendientes', compact('reservas'));
    }
    public function mostrarUnica(Request $request)
    {
        $reserva = $request->reserva;
        $ambientes = $request->ambientes;
        if (strpos($reserva['id'], '-') !== false) {
            // Si es un rango, obtén el rango de IDs
            list($start, $end) = explode('-', $reserva['id']);
            $ids = range($start, $end);
        } else {
            // Si no es un rango, simplemente agrega el ID
            $ids = [$reserva['id']];
        }
        foreach ($ids as $reservaId) {
            $reserva_data = Reserva::findOrFail($reservaId);
            $estado = $reserva_data->estado;
        }
        //dd($reserva);
        // Verificar si el usuario autenticado es el mismo que el docente en la reserva
        if (Auth::check() && Auth::user()->name === $reserva['docente']) {
            return view('Docente.docente', compact('reserva', 'ambientes', 'estado'));
        }
        // Si no coincide, redirigir a login o mostrar mensaje de error
        Auth::logout();
        return redirect()->route('login')->withErrors(['message' => 'No tienes permiso para acceder a esta reserva.']);
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
        $idMateria      = DB::table("materias")->where("nombre", $nombreMateria)->value('id');
        $idGrupoMateria = DB::table("grupo_materias")->where("id_grupo", $idGrupo)->where('id_materia', $idMateria)->value('id');
        $id_usuario_materia = DB::table("usuario_materias")->where('id_user', $id_usuario)->where('id_grupo_materia', $idGrupoMateria)->value('id');

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
        $mensaje->enviarSolicitud($request, $id_usuario_materia);
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
    public function guardarConfiguracion(Request $request)
    {
        // Aquí se guarda la configuración en la sesión
        session(['cantidad_periodos' => $request->cantidad_periodos]);

        // Otras operaciones para guardar la configuración si es necesario

        return redirect()->back()->with('success', 'Configuración guardada correctamente');
    }
}
