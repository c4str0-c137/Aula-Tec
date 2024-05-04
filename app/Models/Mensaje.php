<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    protected $fillable = ['capacidad','usuario','motivo','fecha','horario','materia','grupo','user_id'];
    // protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}