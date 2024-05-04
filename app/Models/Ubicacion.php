<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = ['nombre'];

    public function ambiente(){
        return $this->hasMany(Ambiente::class);
    }
}
