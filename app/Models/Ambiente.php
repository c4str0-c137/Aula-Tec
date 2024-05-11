<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['departamento', 'capacidad', 'numeroaula','id_tipoAmbiente','id_ubicacion'];

    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class , 'id_ubicacion');
    }
    public function tipoAmbiente(){
        return $this->belongsTo(TipoAmbiente::class , 'id_tipoAmbiente');
    }
    public function estado(){
        return $this->belongsTo(Estado::class , 'id_estado');
    }
    public function ambiente_horario(){
        return $this->hasMany(AmbienteHorario::class , 'id_estado');
    }
   
}
