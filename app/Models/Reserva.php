<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    
    protected $fillable = ['capacidad', 'fecha_reserva',];

    public function acontecimiento(){
        return $this->hasOne(Acontecimiento::class , 'id_acontecimiento');
    }

    public function user(){
        return $this->hasMany(User::class , 'id_user');
    }

    public function ambiente(){
        return $this->hasMany(Ambiente::class , 'id_ambiente');
    }

    public function usuario_materia(){
        return $this->hasOne(Usuario_Materia::class , 'id_usaurio_materia');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }
}
