<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'id_rol' => 1,
        ])->assignRole('Administrador');
        User::create([
            'name' => 'Corina Justina Flores Villaroel',
            'email' => 'devg57963@gmail.com',
            'password' => Hash::make('123456789'),
            'id_rol' => 2,
        ])->assignRole('Docente');
        User::create([
            'name' => 'Corina Justina Flores Villaroel',
            'email' => 'docente1@gmail.com',
            'password' => Hash::make('123@22'),
            'id_rol' => 1,
        ])->assignRole('Docente');
    }
}
