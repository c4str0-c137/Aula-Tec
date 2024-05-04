<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Horario::create([
            'horaini' => '06:45:00',
            'horafin' => '08:15:00',
        ]);
        Horario::create([
            'horaini' => '08:15:00',
            'horafin' => '09:45:00',
        ]);
        Horario::create([
            'horaini' => '09:45:00',
            'horafin' => '11:15:00',
        ]);
        Horario::create([
            'horaini' => '11:15:00',
            'horafin' => '12:45:00',
        ]);
        Horario::create([
            'horaini' => '12:45:00',
            'horafin' => '14:15:00',
        ]);
        Horario::create([
            'horaini' => '14:15:00',
            'horafin' => '15:45:00',
        ]);
        Horario::create([
            'horaini' => '15:45:00',
            'horafin' => '17:15:00',
        ]);
        Horario::create([
            'horaini' => '17:15:00',
            'horafin' => '18:45:00',
        ]);
        Horario::create([
            'horaini' => '18:45:00',
            'horafin' => '20:15:00',
        ]);
        Horario::create([
            'horaini' => '20:15:00',
            'horafin' => '22:45:00',
        ]);

    }
}
