<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAmbiente extends Model

{
    protected $table = 'tipo_ambientes';
    public $timestamps = false;
    use HasFactory;
    protected $fillable = ['nombre'];

    public function ambiente(){
        return $this->hasMany(Ambiente::class, 'id_ambiente');
    }
    public function reserva(){
        return $this->hasMany(Reserva::class, 'id_reserva');
    }
}
