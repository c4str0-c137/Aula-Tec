<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo_Materia;

class GrupoMateriasSeeder extends Seeder
{
    public function run()
    {
        // Insertar datos de ejemplo en la tabla grupo_materias
        Grupo_Materia::create([
            'id_grupo' => 1,
            'id_materia' => 3,
        ]);

        Grupo_Materia::create([
            'id_grupo' => 2,
            'id_materia' => 4,
        ]);

        Grupo_Materia::create([
            'id_grupo' => 3,
            'id_materia' => 3,
        ]);

        Grupo_Materia::create([
            'id_grupo' => 4,
            'id_materia' => 4,
        ]);
    }
}