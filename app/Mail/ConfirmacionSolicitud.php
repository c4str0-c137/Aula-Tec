<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;

class ConfirmacionSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $ambientes_disponibles;

    public function __construct($reserva,$ambientes_disponibles)
    {
        $this->reserva = $reserva;
        $this->ambientes_disponibles = $ambientes_disponibles;
    }

    public function build()
    {
        return $this->view('solicitud.index')
                    ->subject('Confirmación de reserva');
    }
}
