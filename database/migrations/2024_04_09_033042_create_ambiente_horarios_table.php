<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbienteHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambiente_horarios', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('id_ambiente')->nullable();
                $table->foreign('id_ambiente')
                    ->references('id')
                    ->on('ambientes');
                $table->unsignedBigInteger('id_horario')->nullable();
                $table->foreign('id_horario')
                    ->references('id')
                    ->on('horarios');
                $table->unsignedBigInteger('id_dia')->nullable();
                $table->foreign('id_dia')
                        ->references('id')
                        ->on('dias');
                $table->unsignedBigInteger('id_estado_horario')->nullable();
                $table->foreign('id_estado_horario')
                        ->references('id')
                        ->on('estado_horarios');
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
        Schema::dropIfExists('ambiente_horarios');
    }
}
