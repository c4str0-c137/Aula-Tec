<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioMateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario_materias')->insert([
        [
            'id' => 1,
            'id_user' => 2,
            'id_grupo_materia' => 1,
        ],
        [
            'id' => 2,
            'id_user' => 2,
            'id_grupo_materia' => 2,
        ],
        [
        'id' => 3,
        'id_user' => 2,
        'id_grupo_materia' => 3,
        ],
        [
        'id' => 4,
        'id_user' => 2,
        'id_grupo_materia' => 4,
        ],
        // Puedes agregar más arrays para insertar más usuarios si es necesario
        ]);
    }  
}
