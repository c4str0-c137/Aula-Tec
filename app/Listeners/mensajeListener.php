<?php

namespace App\Listeners;
use App\Notifications\notificaciones;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class mensajeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = User::find(1); //Solo envia a admin 1
        Notification::send($user, new Notificaciones($event->mensaje));
    }
}