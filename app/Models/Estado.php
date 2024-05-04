<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['estado'];

    public function ambiente(){
        return $this->hasMany(Ambiente::class , 'id_ambiente');
    }
}
