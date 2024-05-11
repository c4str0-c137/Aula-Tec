<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'horaini',
        'horafin',
    ];
    public function ambiente_horario(){
        return $this->hasMany(AmbienteHorario::class, 'id_ambiente_horario');
    }
    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'id_ambiente');
    }
    public function estado_horario()
    {
        return $this->belongsTo(EstadoHorario::class, 'id_estado_horario');
    }
    public function reserva(){
        return $this->hasMany(Reserva::class, 'id_reserva');
    }
    /**public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'id_ambiente');
    }_*/
}


