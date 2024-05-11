<?php

namespace Database\Seeders;

use App\Models\Ambiente;
use Illuminate\Database\Seeder;

class AmbienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ambiente::create([
            'departamento' => 'Fisica',
            'capacidad' => '200',
            'id_tipoAmbiente' => 2,
            'id_ubicacion' => 1,
            'numeroaula' =>'691A',
            'id_estado' => 1
        ]);
        Ambiente::create([
            'departamento' => 'matematicas',
            'capacidad' => '20',
            'id_tipoAmbiente' => 1,
            'id_ubicacion' => 1,
            'numeroaula' =>'692A',
            'id_estado' => 1
        ]);
        Ambiente::create([
            'departamento' => 'Fisica',
            'capacidad' => '20',
            'id_tipoAmbiente' => 3,
            'id_ubicacion' => 1,
            'numeroaula' =>'690A',
            'id_estado' => 1
        ]);
    }
}
