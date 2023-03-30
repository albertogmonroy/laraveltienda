<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('ID_Empleado');
            $table->string('Nombre_Empleado');
            $table->string('Apellido_Empleado');
            $table->string('Dirección_Empleado');
            $table->string('Ciudad_Empleado');
            $table->string('Teléfono_Empleado');
            $table->string('Correo_Empleado')->unique();
            $table->string('Puesto_Empleado');
            $table->date('Fecha_Ingreso');
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
        Schema::dropIfExists('empleados');
    }
}
