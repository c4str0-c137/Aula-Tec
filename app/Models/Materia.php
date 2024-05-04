<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];

    public function grupo_materia(){
        return $this->belongsTo(Grupo_Materia::class, 'id_grupo_materia');
    }

    public function usuario_materia(){
        return $this->belongsTo(Usuario_Materia::class, 'id_usuario_materia');
    }
}
