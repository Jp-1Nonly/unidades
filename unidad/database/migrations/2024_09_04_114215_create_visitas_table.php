<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitante_id');
            $table->unsignedBigInteger('residente_id');
            $table->timestamp('fecha_ingreso')->nullable();
            $table->timestamp('fecha_salida')->nullable();
            $table->string('motivo_visita');
            $table->string('vehiculo')->nullable();
            $table->timestamps();
            
            // Definir claves foráneas si las tablas referenciadas existen
            $table->foreign('visitante_id')->references('id')->on('visitantes')->onDelete('cascade');
            $table->foreign('residente_id')->references('id')->on('residentes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitas');
    }
}
