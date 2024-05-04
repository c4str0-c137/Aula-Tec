<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_materias', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('id_grupo');
        $table->foreign('id_grupo')
            ->references('id')
            ->on('grupos');
        $table->unsignedBigInteger('id_materia');
        $table->foreign('id_materia')
            ->references('id')
            ->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupo__materias');
    }
}
