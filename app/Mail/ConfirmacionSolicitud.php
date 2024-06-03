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
    public $ambientes;

    public function __construct($reserva,$ambientes)
    {
        $this->reserva = $reserva;
        $this->ambientes = $ambientes;
    }

    public function build()
    {
        return $this->view('solicitud.index')
                    ->subject('Confirmación de reserva');
    }
}
