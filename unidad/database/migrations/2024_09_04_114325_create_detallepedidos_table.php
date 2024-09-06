<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallepedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallepedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');  // Relación con la tabla pedidos
            $table->unsignedBigInteger('producto_id');  // Relación con la tabla productos
            $table->string('medida');  // Medida del producto (por ejemplo, kg, litros, etc.)
            $table->integer('cantidad');  // Cantidad del producto
            $table->decimal('precio_unitario', 10, 2);  // Precio unitario del producto
            $table->decimal('total', 10, 2);  // Total del detalle (cantidad * precio_unitario)
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detallepedidos');
    }
};