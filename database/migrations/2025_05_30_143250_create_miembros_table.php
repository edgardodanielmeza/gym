<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosTable extends Migration
{
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('foto')->nullable(); // ruta o url de la imagen
            $table->string('codigo_acceso_hash')->nullable();
            $table->text('huella_digital')->nullable(); // plantilla biométrica cifrada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('miembros');
    }
}