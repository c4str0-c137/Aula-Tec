<?php

namespace Database\Seeders;
use App\Models\dia;
use Illuminate\Database\Seeder;

class DialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dia::create([
            'nombre' => 'Lunes',
        ]);

        dia::create([
            'nombre' => 'Martes',
        ]);

        dia::create([
            'nombre' => 'Miercoles',
        ]);

        dia::create([
            'nombre' => 'Jueves',
        ]);

        dia::create([
            'nombre' => 'Viernes',
        ]);

        dia::create([
            'nombre' => 'Sabado',
        ]);
    }
}
