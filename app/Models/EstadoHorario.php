<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoHorario extends Model
{
    use HasFactory;
    
    // Nombre de la tabla en la base de datos
    protected $table = 'estado_horarios';

    // Los campos que se pueden asignar masivamente
    protected $fillable = ['estado'];

    public $timestamps = false;

    

    // Relación con el modelo AmbienteHorario
    public function ambiente_horaio()
    {
        return $this->hasMany(AmbienteHorario::class , 'id_ambiente_horario');
    }
}
