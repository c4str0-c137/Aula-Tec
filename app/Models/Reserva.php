<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    
    protected $fillable = ['capacidad', 
    'fecha_reserva', 
    'id_usuario_materia', 
    'id_acontecimiento', 
    'id_horario', 
    'id_tipoAmbiente',
    'estado'];

    public function acontecimiento()
    {
        return $this->belongsTo(Acontecimiento::class, 'id');
    }

    public function user(){
        return $this->hasMany(User::class , 'id');
    }

    public function ambiente(){
        return $this->hasMany(Ambiente::class , 'id');
    }

    public function usuario_materia(){
        return $this->hasOne(Usuario_Materia::class , 'id');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id');
    }
    public function tipoAmbiente()
    {
        return $this->belongsTo(TipoAmbiente::class, 'id');
    }
}
