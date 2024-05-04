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
            'tipoDeAmbiente' => 'Auditorio',
            'id_ubicacion' => 1,
            'id_estado' => 1,
        ]);
        Ambiente::create([
            'departamento' => 'matematicas',
            'capacidad' => '20',
            'tipoDeAmbiente' => '623',
            'id_ubicacion' => 1,
            'id_estado' => 1,
        ]);
        Ambiente::create([
            'departamento' => 'Fisica',
            'capacidad' => '20',
            'tipoDeAmbiente' => '624',
            'id_ubicacion' => 1,
            'id_estado' => 1,
        ]);
    }
}
