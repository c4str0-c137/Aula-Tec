<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Mensaje;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class notificaciones extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Mensaje $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mensaje'  => $this->mensaje->id,
            'materia' => $this->mensaje->materia,
            'tipo_ambiente' => $this->mensaje->tipo_ambiente,
            'idusuario_materias' => $this->mensaje->idusuario_materias,
            'capacidad' => $this->mensaje->capacidad,
            'grupo'   =>  $this->mensaje->grupo,
            'motivo' => $this->mensaje->motivo,
            'fecha' => $this->mensaje->fecha,
            'horario' => $this->mensaje->horario,
            'user_id'   =>  $this->mensaje->user_id,
            'time'  =>  Carbon::now()->diffForHumans(),
        ];
    }
}
