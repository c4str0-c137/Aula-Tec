<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Materia extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function user(){
        return $this->hasMany(User::class, 'id_user');
    }

    public function grupo_materia(){
        return $this->hasMany(Grupo_Materia::class, 'id_grupo_materia');
    }
    public function reserva(){
        return $this->hasOne(Reserva::class , 'id_reserva');
    }
}
