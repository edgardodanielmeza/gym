<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosAccesoTable extends Migration
{
    public function up()
    {
        Schema::create('eventos_acceso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('miembro_id')->constrained()->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained()->onDelete('cascade');
            $table->foreignId('dispositivo_acceso_id')->constrained('dispositivos_acceso')->onDelete('cascade');
            $table->dateTime('fecha_hora');
            $table->enum('resultado', ['permitido', 'denegado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos_acceso');
    }
}