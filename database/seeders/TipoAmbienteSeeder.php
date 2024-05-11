<?php

namespace Database\Seeders;
use App\Models\TipoAmbiente;
use Illuminate\Database\Seeder;

class TipoAmbienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAmbiente::create([
            'nombre' => 'Aula',
        ]);

        TipoAmbiente::create([
            'nombre' => 'Laboratorio',
        ]);

        TipoAmbiente::create([
            'nombre' => 'Auditorio',
        ]);
    }
}
