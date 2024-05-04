<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_materias', function (Blueprint $table) {
            $table->id();
        
        $table->unsignedBigInteger('id_user');
        $table->foreign('id_user')
            ->references('id')
            ->on('users');

        $table->unsignedBigInteger('id_grupo_materia');
        $table->foreign('id_grupo_materia')
            ->references('id')
            ->on('grupo_materias');

            
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario__materias');
    }
}
