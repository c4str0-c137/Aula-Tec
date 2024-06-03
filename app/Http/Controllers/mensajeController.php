<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\mensajeEvent;
use App\Notifications\notificaciones;
use App\Models\Mensaje;
use App\Models\User;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ambiente;
use App\Models\AmbienteHorario;
use App\Models\TipoAmbiente;
use App\Mail\ConfirmacionSolicitud; // Asegúrate de tener el namespace correcto para la clase ConfirmarReserva
use Illuminate\Support\Facades\Mail;
use DateTime;

class mensajeController extends Controller
{
    public function create()
    {
        return view('mensaje.create');
    }

    public function store(Request $request)
    {
        $data               = $request->all();
        $data['user_id']    = Auth::id();
        $post               = Mensaje::create($data);
        event(new mensajeEvent($post));
        return redirect()->back()->with('message', 'Reserva enviada');
    }

    public function enviarSolicitud(Request $request, $idusuario_materias)
    {
        $data                       = $request->all();
        $data['user_id']            = Auth::id();
        $data['idusuario_materias'] = $idusuario_materias;
        $horariosSeleccionados      = $request->input('horario');

        foreach ($horariosSeleccionados as $horario) {
            $data['horario']    = $horario;
            $mensaje            = Mensaje::create($data);
            event(new mensajeEvent($mensaje));
        }
        return redirect()->back()->with('message', 'Reserva enviada');
    }
    public function index()
    {
        $reservas = $this->listReservas();
        return view('mensaje.notifications', compact('reservas'));
    }

    public function unico($id)
    {
        $reservas = $this->listReservas();
        return view('mensaje.detalle', compact('reservas', 'id'));
    }

    public function listReservas()
    {
        $reservas = DB::table('reservas')
            ->join('usuario_materias', 'reservas.id_usuario_materia', '=', 'usuario_materias.id')
            ->join('users', 'usuario_materias.id_user', '=', 'users.id')
            ->join('grupo_materias', 'usuario_materias.id_grupo_materia', '=', 'grupo_materias.id')
            ->join('materias', 'grupo_materias.id_materia', '=', 'materias.id')
            ->join('grupos', 'grupo_materias.id_grupo', '=', 'grupos.id')
            ->join('acontecimientos', 'reservas.id_acontecimiento', '=', 'acontecimientos.id')
            ->join('tipo_ambientes', 'reservas.id_tipoAmbiente', '=', 'tipo_ambientes.id')
            ->join('horarios', 'reservas.id_horario', '=', 'horarios.id')
            ->select(
                'reservas.id',
                'reservas.fecha_reserva',
                'reservas.id_usuario_materia',
                'usuario_materias.id_user as id_user',
                'usuario_materias.id_grupo_materia as id_grupo_materia',
                'users.name as docente',
                'materias.nombre as materia',
                'grupos.grupo as grupo',
                'acontecimientos.tipo as acontecimiento',
                'horarios.horaini',
                'horarios.horafin',
                'reservas.capacidad',
                'tipo_ambientes.nombre as tipo_ambiente',
                'reservas.estado'
            )
            ->orderByRaw('CASE WHEN reservas.id_acontecimiento = 5 THEN 1 ELSE 0 END ASC')
            ->orderBy('reservas.fecha_reserva', 'asc')
            ->orderBy('horarios.horaini', 'asc')
            ->get();

        $result = collect($reservas)->groupBy(function ($item) {
            return $item->fecha_reserva . '-' . $item->id_usuario_materia;
        })->map(function ($group) {
            $groupedByContinuity = [];
            $currentGroup = [];
            $previousHorario = null;

            foreach ($group as $item) {
                if ($previousHorario === null || $previousHorario->horafin == $item->horaini) {
                    $currentGroup[] = $item;
                } else {
                    $groupedByContinuity[] = $currentGroup;
                    $currentGroup = [$item];
                }
                $previousHorario = $item;
            }

            if (!empty($currentGroup)) {
                $groupedByContinuity[] = $currentGroup;
            }

            return $groupedByContinuity;
        })->flatten(1)->mapWithKeys(function ($group) {
            $first = $group[0];
            $last = end($group);
            $key = count($group) > 1 ? $first->id . '-' . $last->id : $first->id;
            return [$key => (object) [
                'id' => $key,
                'fecha_reserva' => $first->fecha_reserva,
                'id_usuario_materia' => $first->id_usuario_materia,
                'id_user' => $first->id_user,
                'id_grupo_materia' => $first->id_grupo_materia,
                'docente' => $first->docente,
                'materia' => $first->materia,
                'grupo' => $first->grupo,
                'acontecimiento' => $first->acontecimiento,
                'horario' => count($group) > 1 ? $first->horaini . '-' . $last->horafin : $first->horaini,
                'capacidad' => $first->capacidad,
                'tipo_ambiente' => $first->tipo_ambiente,
                'estado' => $first->estado
            ]];
        });
        return $result;
    }

    public function confirmarReserva($id, Request $request)
    {
        // Obtener la información necesaria de la reserva
        $ambientes = $request->input('ambientes');
        
        // Verificar si el id es un rango
        if (strpos($id, '-') !== false) {
            list($start, $end) = explode('-', $id);
            $ids = range($start, $end);
        } else {
            $ids = [$id];
        }
        
        // Obtener las reservas en el rango
        $reservas = DB::table('reservas')->whereIn('id', $ids)->get();
        
        // Compilar información del usuario y el correo electrónico del primer registro
        if ($reservas->isNotEmpty()) {
            $firstReserva = $reservas->first();
            $userMateria = $firstReserva->id_usuario_materia;
            $idUser = DB::table("usuario_materias")->where('id', $userMateria)->value('id_user');
            $userCorreo = User::where('id', $idUser)->value('email');
        }
        $reserva_rango = $this->listReservas()->get($id);
        // Enviar un solo correo electrónico con todas las reservas del rango
        Mail::to($userCorreo)->send(new ConfirmacionSolicitud($reserva_rango, $ambientes));
        
        foreach ($reservas as $reserva_data) {
            // Cambiar el estado de la reserva a 'pendiente'
            DB::table('reservas')->where('id', $reserva_data->id)->update(['estado' => 'pendiente']);
            
            if ($ambientes != null) {
                foreach ($ambientes as $ambiente) {
                    $this->desactivarAula($ambiente, $reserva_data->fecha_reserva, $reserva_data->id_horario);
                }
            } else {
                return redirect('/mensaje')->with('message', 'Notificacion de Aula no disponible');
            }
        }
        
        return redirect('/mensaje')->with('message', 'Solicitud de Reserva Enviada');
    }
    
    public function desactivarAula($ambiente, $fecha_reserva, $id_horario)
    {
        $aula = DB::table('ambientes')
            ->where('numeroaula', $ambiente)
            ->first(['id']);
        $date = $fecha_reserva;
        $dateTime = new DateTime($date);
        $dayOfWeek = $dateTime->format('l');
    
        $diasSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sabado',
            'Sunday' => 'Domingo'
        ];
    
        $diaSemanaEsp = $diasSemana[$dayOfWeek];
        $dia = DB::table('dias')
            ->where('nombre', $diaSemanaEsp)
            ->value('id');
        $aulaId = $aula->id;
        $updated = DB::table('ambiente_horarios')
            ->where('id_ambiente', $aulaId)
            ->where('id_horario', $id_horario)
            ->where('id_dia', $dia)
            ->update(['id_estado_horario' => 3]);
    }
    
    public function markNotification(Request $request)
    {
        // Obtener el ID de la notificación de la solicitud
        $user = auth()->user();
        $notificationId = $request->id;
        // Marcar la notificación como leída
        auth()->user()->notifications()->where('id', $notificationId)->first()->markAsRead();

        // Retornar una respuesta exitosa
        return redirect()->back()->with('message', 'Reserva confirmada');
    }
    public function showAsignacionForm($id)
    {
        $departamentos = DB::table('ambientes')->distinct()->pluck('departamento');

        return view('Horario.buscar', ['id' => $id, 'departamentos' => $departamentos]);
    }

    public function asignarAmbiente($id, Request $request)
    {
        $capacidad = $request->query('capacidad');
        $tipo_ambiente = $request->query('tipo_ambiente');
        $horario = $request->query('horario');

        $departamentos = DB::table('ambientes')->distinct()->pluck('departamento');

        return view('Horario.buscar', [
            'id' => $id,
            'capacidad' => $capacidad,
            'tipo_ambiente' => $tipo_ambiente,
            'horario' => $horario,
            'departamentos' => $departamentos
        ]);
    }
    public function buscarAmbientes(Request $request)
    {
        $capacidad = $request->input('capacidad');
        $tipo_ambiente = $request->input('tipo_ambiente');
        $horario = $request->input('horario');

        $ambientes = DB::table('ambientes as a')
            ->join('ambiente_horarios as ah', 'a.id', '=', 'ah.id_ambiente')
            ->join('ubicacions as u', 'a.id_ubicacion', '=', 'u.id')
            ->join('dias as d', 'ah.id_dia', '=', 'd.id')
            ->join('estado_horarios as e', 'ah.id_estado_horario', '=', 'e.id')
            ->join('horarios as h', 'ah.id_horario', '=', 'h.id')
            ->where('a.capacidad', $capacidad)
            ->where('a.id_tipoAmbiente', function ($query) use ($tipo_ambiente) {
                $query->select('id')
                    ->from('tipo_ambientes')
                    ->where('nombre', $tipo_ambiente);
            })
            ->where('ah.id_estado_horario', 1)
            ->where('h.horaini', $horario)
            ->where('e.id', 1)
            ->select('a.numeroaula')
            ->get();

        return response()->json($ambientes);
    }
    public function getUbicaciones(Request $request)
    {
        $departamento = $request->input('departamento');
        $ubicaciones = DB::table('ambientes as a')
            ->join('ubicacions as u', 'a.id_ubicacion', '=', 'u.id')
            ->where('a.departamento', $departamento)
            ->distinct()
            ->pluck('u.nombre');

        return response()->json($ubicaciones);
    }
    public function getAmbientes(Request $request)
    {
        $departamento = $request->input('departamento');
        $ubicacion = $request->input('ubicacion');
        $horario = $request->input('horario');

        $ambientes = DB::table('ambientes as a')
            ->join('ubicacions as u', 'a.id_ubicacion', '=', 'u.id')
            ->join('ambiente_horarios as ah', 'a.id', '=', 'ah.id_ambiente')
            ->join('horarios as h', 'ah.id_horario', '=', 'h.id')
            ->where('a.departamento', $departamento)
            ->where('u.nombre', $ubicacion)
            ->where('ah.id_estado_horario', 1)
            ->where('h.horaini', $horario)
            ->select('a.numeroaula', 'a.capacidad')
            ->get();

        return response()->json($ambientes);
    }
}
