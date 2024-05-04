<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\mensajeEvent;
use App\Notifications\Notificaciones;
use App\Models\Mensaje;
use App\Models\User;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    public function enviarSolicitud(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
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
        $user = auth()->user();
        $postNotifications = $user->unreadNotifications;

        $notificationsData = [];

        foreach ($postNotifications as $notification) {
            $data = $notification->data;

            $materia = $data['materia'];
            $grupoId = $data['grupo'];
            $userId = $data['user_id'];
            $capacidad = $data['capacidad'];
            $horarioId = $data['horario'];
            $fecha = $data['fecha'];
            $motivoId = $data['motivo'];

            $materiaId = DB::table('materias')->where('nombre', $materia)->value('id');
            $grupo = $grupoId; //DB::table('grupos')->where('id', $grupoId)->value('grupo');
            $user = User::find($userId)->name;
            $motivo = DB::table('acontecimientos')->where('id', $motivoId)->value('tipo');
            $horario = DB::table('horarios')->where('id', $horarioId)->value('horaini');
            $notificationsData[] = [
                'id' => $notification['id'],
                'capacidad' => $capacidad,
                'Solicitante' => $user,
                'id_user' => $userId,
                'Motivo' => $motivo,
                'id_motivo' => $motivoId,
                'Fecha' => $fecha,
                'Horario' => $horario,
                'id_horario' => $horarioId,
                'Grupo' => $grupo,
                'Materia' => $materia,
                'id_materia' => $materiaId,
                'id_usuario_materia' => $userId,
                'created_at' => $notification->created_at,
            ];
        }

        return view('mensaje.notifications', compact('notificationsData'));
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
}