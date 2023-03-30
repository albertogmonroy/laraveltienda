<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('ID_Venta');
            $table->unsignedBigInteger('ID_Producto');
            $table->foreign('ID_Producto')->references('ID_Producto')->on('productos');
            $table->unsignedBigInteger('ID_Cliente');
            $table->foreign('ID_Cliente')->references('ID_Cliente')->on('clientes');
            $table->date('Fecha_Venta');
            $table->integer('Cantidad_Vendida');
            $table->decimal('Precio_Total', 8, 2);
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
        Schema::dropIfExists('ventas');
    }
}
