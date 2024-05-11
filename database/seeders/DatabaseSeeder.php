<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this ->call(RolSeeder::class);
        $this ->call(GrupoSeeder::class);
        $this ->call(MateriaSeeder::class);
        $this ->call(RoleSeeder::class);
        $this ->call(EstadoSeeder::class);
        $this ->call(UserSeeder::class);
        $this ->call(UbicacionSeeder::class);
        $this ->call(TipoAmbienteSeeder::class);
        $this ->call(AmbienteSeeder::class);
        $this ->call(HorarioSeeder::class);
        $this ->call(DialSeeder::class);
        $this ->call(EstadoHorarios::class);
        $this ->call(GrupoMateriasSeeder::class);
        $this ->call(UsuarioMateriasSeeder::class); 
        $this ->call(acontecimientoSeeder::class);
        

    }
}
