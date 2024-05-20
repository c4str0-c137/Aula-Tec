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
        $notificationsData = $this->dataNotification();
        $reservas = DB::table('reservas')
            ->join('usuario_materias', 'reservas.id_usuario_materia', '=', 'usuario_materias.id')
            ->join('users', 'usuario_materias.id_user', '=', 'users.id')
            ->join('grupo_materias', 'usuario_materias.id_grupo_materia', '=', 'grupo_materias.id')
            ->join('materias', 'grupo_materias.id_materia', '=', 'materias.id')
            ->join('grupos', 'grupo_materias.id_grupo', '=', 'grupos.id')
            ->join('acontecimientos', 'reservas.id_acontecimiento', '=', 'acontecimientos.id')
            ->join('horarios', 'reservas.id_horario', '=', 'horarios.id')
            ->join('tipo_ambientes', 'reservas.id_tipoAmbiente', '=','tipo_ambientes.id')
            ->select(
                'reservas.*',
                'usuario_materias.id_user as id_user',
                'usuario_materias.id_grupo_materia as id_grupo_materia',
                'users.name as docente',
                'materias.nombre as materia',
                'grupos.grupo as grupo',
                'acontecimientos.tipo as acontecimiento',
                'horarios.horaini as horario',
                'tipo_ambientes.nombre as tipo_ambiente'
            )
            ->orderByRaw('CASE WHEN reservas.id_acontecimiento = 5 THEN 1 ELSE 0 END ASC') // Mover id_acontecimiento 5 al final
            ->orderBy('reservas.fecha_reserva', 'asc')  // Ordenar por created_at en orden descendente
            ->orderBy('horarios.horaini', 'asc')
            ->get();
        return view('mensaje.notifications', compact('reservas'));
    }
    
    public function unico($id)
    {
        $notificationsData = $this->dataNotification();
        $reservas = DB::table('reservas')
            ->join('usuario_materias', 'reservas.id_usuario_materia', '=', 'usuario_materias.id')
            ->join('users', 'usuario_materias.id_user', '=', 'users.id')
            ->join('grupo_materias', 'usuario_materias.id_grupo_materia', '=', 'grupo_materias.id')
            ->join('materias', 'grupo_materias.id_materia', '=', 'materias.id')
            ->join('grupos', 'grupo_materias.id_grupo', '=', 'grupos.id')
            ->join('acontecimientos', 'reservas.id_acontecimiento', '=', 'acontecimientos.id')
            ->join('horarios', 'reservas.id_horario', '=', 'horarios.id')
            ->join('tipo_ambientes', 'reservas.id_tipoAmbiente', '=','tipo_ambientes.id')
            ->select(
                'reservas.*',
                'usuario_materias.id_user as id_user',
                'usuario_materias.id_grupo_materia as id_grupo_materia',
                'users.name as docente',
                'materias.nombre as materia',
                'grupos.grupo as grupo',
                'acontecimientos.tipo as acontecimiento',
                'horarios.horaini as horario',
                'tipo_ambientes.nombre as tipo_ambiente'
            )
            ->orderByRaw('CASE WHEN reservas.id_acontecimiento = 5 THEN 1 ELSE 0 END ASC') // Mover id_acontecimiento 5 al final
            ->orderBy('reservas.fecha_reserva', 'asc')  // Ordenar por created_at en orden descendente
            ->orderBy('horarios.horaini', 'asc')
            ->get();
        return view('mensaje.detalle', compact('reservas','id'));
    }

    public function dataNotification()
    {
        $user = auth()->user();
        $postNotifications = $user->unreadNotifications;

        $notificationsData = [];

        foreach ($postNotifications as $notification) {
            $data               = $notification->data;
            $userId             = $data['user_id'];
            $capacidad          = $data['capacidad'];
            $horarioId          = $data['horario'];
            $fecha              = $data['fecha'];
            $motivoId           = $data['motivo'];
            $Idtipo_ambiente    = $data['tipo_ambiente'];
            $idusuario_materias = $data['idusuario_materias'];

            $idgrupo_materia    = DB::table('usuario_materias')->where('id', $idusuario_materias)->value('id_grupo_materia');
            $idgrupo            = DB::table('grupo_materias')->where('id', $idgrupo_materia)->value('id_grupo');
            $idmateria          = DB::table('grupo_materias')->where('id', $idgrupo_materia)->value('id_materia');
            $materia            = DB::table('materias')->where('id', $idmateria)->value('nombre');
            $grupo              = DB::table('grupos')->where('id', $idgrupo_materia)->value('grupo');
            $user               = User::find($userId)->name;
            $motivo             = DB::table('acontecimientos')->where('id', $motivoId)->value('tipo');
            $horario            = DB::table('horarios')->where('id', $horarioId)->value('horaini');
            $tipo_ambiente      = DB::table('tipo_ambientes')->where('id', $Idtipo_ambiente)->value('nombre');
            $notificationsData[] = [
                'id'                => $notification['id'],
                'tipo_ambiente'     => $Idtipo_ambiente,
                'ambiente'          => $tipo_ambiente,
                'capacidad'         => $capacidad,
                'Solicitante'       => $user,
                'id_user'           => $userId,
                'Motivo'            => $motivo,
                'id_motivo'         => $motivoId,
                'Fecha'             => $fecha,
                'Horario'           => $horario,
                'id_horario'        => $horarioId,
                'Grupo'             => $grupo,
                'Materia'           => $materia,
                'id_materia'        => $idmateria,
                'id_usuario_materia'=> $userId,
                'created_at'        => $notification->created_at,
            ];
        }
        return $notificationsData;
    }

    public function confirmarReserva($id, Request $request)
    {
        // Obtener la información necesaria de la reserva
        $reserva = Reserva::findOrFail($id);
        $ambientes = $request->input('ambientes_disponibles');
        $userMateria = $reserva->id_usuario_materia;
        $idUser = DB::table("usuario_materias")->where('id', $userMateria)->value('id_user');
        $userCorreo = User::where('id', $idUser)->value('email');
        $reserva_data = DB::table('reservas')
            ->join('usuario_materias', 'reservas.id_usuario_materia', '=', 'usuario_materias.id')
            ->join('users', 'usuario_materias.id_user', '=', 'users.id')
            ->join('grupo_materias', 'usuario_materias.id_grupo_materia', '=', 'grupo_materias.id')
            ->join('materias', 'grupo_materias.id_materia', '=', 'materias.id')
            ->join('grupos', 'grupo_materias.id_grupo', '=', 'grupos.id')
            ->join('acontecimientos', 'reservas.id_acontecimiento', '=', 'acontecimientos.id')
            ->join('horarios', 'reservas.id_horario', '=', 'horarios.id')
            ->join('tipo_ambientes', 'reservas.id_tipoAmbiente', '=','tipo_ambientes.id')
            ->select(
                'reservas.*',
                'usuario_materias.id_user as id_user',
                'usuario_materias.id_grupo_materia as id_grupo_materia',
                'users.name as docente',
                'materias.nombre as materia',
                'grupos.grupo as grupo',
                'acontecimientos.tipo as acontecimiento',
                'horarios.horaini as horario',
                'tipo_ambientes.nombre as tipo_ambiente'
            )
            ->where('reservas.id', $reserva->id) // Filtro por ID de reserva
            ->first(); //dd($reserva);
        // Envía el correo electrónico de confirmación
        Mail::to($userCorreo)->send(new ConfirmacionSolicitud($reserva_data,$ambientes));
        if($ambientes != null){
            $aula = DB::table('ambientes')
            ->where('numeroaula', $ambientes)
            ->first(['id']);
            $date = $reserva->fecha_reserva;
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
             ->where('id_horario', $reserva->id_horario)
             ->where('id_dia', $dia)
             ->update(['id_estado_horario' => 2]);
            return redirect('/mensaje')->with('message', 'Solicitud de Reserva Enviada');
        }else{
            return redirect('/mensaje')->with('message', 'Notificacion de Aula no disponible');
        }
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
    // Aquí debes obtener los ambientes disponibles y pasarlos a la vista
 //  $ambientes = buscarAmbientes(); // Esto es un ejemplo, debes obtener los ambientes de acuerdo a tu lógica

    // Luego, pasas los ambientes a la vista
    return view('Horario.buscar', ['id' => $id]);
}

public function asignarAmbiente($id, Request $request)
    {
        $capacidad = $request->query('capacidad');
        $tipo_ambiente = $request->query('tipo_ambiente');
        $horario = $request->query('horario');

        return view('Horario.buscar', [
            'id' => $id,
            'capacidad' => $capacidad,
            'tipo_ambiente' => $tipo_ambiente,
            'horario' => $horario
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
            ->where('a.id_tipoAmbiente', function($query) use ($tipo_ambiente) {
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
    
}