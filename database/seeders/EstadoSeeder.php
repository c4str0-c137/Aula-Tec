<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::create([
            'estado' => 1,//estado de activo
        ]);
        Estado::create([
            'estado' => 2,//estado de inactivo
        ]);
    }
}
