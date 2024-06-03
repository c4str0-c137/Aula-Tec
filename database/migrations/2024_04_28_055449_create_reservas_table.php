<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->integer('capacidad');
            $table->date('fecha_reserva');
        
        $table->unsignedBigInteger('id_usuario_materia');
        $table->foreign('id_usuario_materia')
            ->references('id')
            ->on('usuario_materias');
        
        $table->unsignedBigInteger('id_acontecimiento');
        $table->foreign('id_acontecimiento')
            ->references('id')
            ->on('acontecimientos');
        $table->unsignedBigInteger('id_horario')->nullable();
        $table->foreign('id_horario')
            ->references('id')
            ->on('horarios');
        
        $table->unsignedBigInteger('id_tipoAmbiente');
        $table->foreign('id_tipoAmbiente')
            ->references('id')
            ->on('tipo_ambientes');
        $table->string('estado')->default('nueva');
        $table->timestamps();

        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
