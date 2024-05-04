<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acontecimiento extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['tipo',];

    public function reserva(){
        return $this->belongsTo(Reserva::class , 'id_reserva');
    }
}
