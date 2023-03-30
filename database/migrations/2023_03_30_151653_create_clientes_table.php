<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('ID_Cliente');
            $table->string('Nombre_Cliente');
            $table->string('Apellido_Cliente');
            $table->string('Dirección_Cliente');
            $table->string('Ciudad_Cliente');
            $table->string('Teléfono_Cliente');
            $table->string('Correo_Cliente')->unique();
            $table->date('Fecha_Registro');
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
        Schema::dropIfExists('clientes');
    }
}
