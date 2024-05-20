<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acontecimiento;

class acontecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acontecimiento::create([
            'tipo' => "1er parcial"
        ]);
        Acontecimiento::create([
            'tipo' => "2do parcial"
        ]);
        Acontecimiento::create([
            'tipo' => "Examen Final"
        ]);
        Acontecimiento::create([
            'tipo' => "2da Instancia"
        ]);
        Acontecimiento::create([
            'tipo' => "Tesis"
        ]);
    }
}
