<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create([
            'grupo' =>'Grupo-1'
        ]);

        Grupo::create([
            'grupo' =>'Grupo-2'
        ]);
        Grupo::create([
            'grupo' =>'Grupo-3'
        ]);

        Grupo::create([
            'grupo' =>'Grupo-4'
        ]);
        Grupo::create([
            'grupo' =>'Grupo-5'
        ]);

        Grupo::create([
            'grupo' =>'Grupo-6'
        ]);
        
    }
}
