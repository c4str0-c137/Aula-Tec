<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'grupo'
    ];
    public function grupo_materia(){
        return $this->hasMany(Grupo_Materia::class, 'id_grupo_materia');
    }
}
