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



class mensajeController extends Controller
{
    public function create()
    {
        return view('mensaje.create');
    }

    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $post = Mensaje::create($data);
        // auth()->user()->notify(new PostNotification($post));
        // User::all()
        //     ->except($post->user_id)
        //     ->each(function(User $user) use ($post){
        //         $user->notify(new Notificaciones($post));
        //     });
        event(new mensajeEvent($post));
        return redirect()->back()->with('message', 'Reserva enviada');
    }

    public function enviarSolicitud(Request $request, $idusuario_materias)
    {
        $data           = $request->all();
        $data['user_id']= Auth::id();
        $data['idusuario_materias']= $idusuario_materias;
        $horariosSeleccionados = $request->input('horario');
        foreach ($horariosSeleccionados as $horario) {
            $data['horario'] = $horario;
            $mensaje = Mensaje::create($data);        
            event(new mensajeEvent($mensaje));
        }
        return redirect()->back()->with('message', 'Reserva enviada');
    }
    public function index() 
    {
        $notificationsData = $this->dataNotification();
        return view('mensaje.notifications', compact('notificationsData'));
    }
    
    public function unico($notificationId)
    {
        $notificationsData = $this->dataNotification();
        return view('mensaje.detalle', compact('notificationsData','notificationId'));
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

    public function confirmarReserva(Request $request)
    {
        $user = auth()->user();
        $reserva = new Reserva();
        $reserva->materia_id = $request->materia_id;
        $reserva->grupo_id = $request->grupo_id;
        $reserva->user_id = $request->user_id;
        $reserva->save();
        return redirect()->back()->with('message', 'Reserva enviada');
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
    
    public function buscarAmbientes(Request $request) {
        $capacidad = $request->input('capacidad');
    
        $ambientes = Ambiente::where('capacidad', $capacidad)->get();
    
        return response()->json($ambientes);
    }

    
    
}