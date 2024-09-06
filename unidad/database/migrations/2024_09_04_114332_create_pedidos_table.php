<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
       
            $table->unsignedBigInteger('proveedor_id');  // Relación con la tabla de profesores
     
            $table->string('estado');  // Estado del pedido (pendiente, completado, cancelado, etc.)
            $table->text('observaciones')->nullable();  // Observaciones adicionales
            $table->decimal('total', 10, 2);  // Total del pedido
        
            $table->timestamps();

            // Definir claves foráneas
         
            $table->foreign('proveedor_id')->references('id')->on('profesores')->onDelete('cascade');
          
        });
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}

