<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambientes', function (Blueprint $table) {
            $table->id();
            $table->string('departamento', 30);
            $table->integer('capacidad');
            $table->string('numeroaula', 30);


           

            $table->unsignedBigInteger('id_ubicacion');
            $table->foreign('id_ubicacion')
                ->references('id')
                ->on('ubicacions');

            $table->unsignedBigInteger('id_estado')->default(1);
            $table->foreign('id_estado')
                ->references('id')
                ->on('estados');
                  
            $table->unsignedBigInteger('id_tipoAmbiente');
            $table->foreign('id_tipoAmbiente')
                ->references('id')
                ->on('tipo_ambientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambientes');
    }
}
