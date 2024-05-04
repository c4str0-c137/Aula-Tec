<?php

namespace Database\Seeders;

use App\Models\Materia;
use Illuminate\Database\Seeder;

class MateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materia::create([
            'nombre' => 'CalculoII',
        ]);
        Materia::create([
            'nombre' => 'CalculoI',
        ]);
        Materia::create([
            'nombre' => 'Taller de Ingenieria de Software',
        ]);
        Materia::create([
            'nombre' => 'Introduccion a la Programcion',
        ]);
    }
}
