<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositivosAccesoTable extends Migration
{
    public function up()
    {
        Schema::create('dispositivos_acceso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['teclado', 'biometrico', 'qr']);
            $table->string('estado')->default('activo'); // activo, inactivo, falla
            $table->string('ip_configuracion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dispositivos_acceso');
    }
}