<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ROLES
        $admin2 = Role::create(['name' => 'Administrador']);
        $docente2 = Role::create(['name' => 'Docente']);

        //PERMISOS
        Permission::create(['name'=> 'auth.login', 'description' => 'Ver el Dashboard'])->syncRoles([$admin2, $docente2]);
        Permission::create(['name'=> 'Ambiente.index', 'description' => 'Ver el Dashboard'])->assignRole([$admin2]);

        //AMBIENTES
        Permission::create(['name' => 'Ambiente.create', 'description' => 'Crear ambiente'])->assignRole([$admin2]);
        Permission::create(['name' => 'Ambiente.edit', 'description' => 'Editar categoria'])->assignRole([$admin2]);
        

        //HORARIOS
        Permission::create(['name' => 'Horario.index', 'description' => 'Ver ambientes'])->assignRole([$admin2]);
        Permission::create(['name' => 'Horario.create', 'description' => 'Crear ambiente'])->assignRole([$admin2]);
        Permission::create(['name' => 'Horario.edit','description' => 'Editar categoria'])->assignRole([$admin2]);

        //Solicitud
        Permission::create(['name'=> 'Solicitud.index', 'description' => 'Solicitar Reserva'])->assignRole([$docente2]);

    }
}
