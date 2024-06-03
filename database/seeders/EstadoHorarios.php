<?php

namespace Database\Seeders;
use App\Models\EstadoHorario;
use Illuminate\Database\Seeder;



class EstadoHorarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoHorario::create([
            'estado' => 'Activo',
        ]);

        EstadoHorario::create([
            'estado' => 'Inactivo',
        ]);
        EstadoHorario::create([
            'estado' => 'Pendiente',
        ]);

    }
}
