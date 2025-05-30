<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresiasTable extends Migration
{
    public function up()
    {
        Schema::create('membresias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('miembro_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['mensual', 'trimestral', 'anual', 'otro']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activa', 'suspendida', 'cancelada', 'vencida'])->default('activa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('membresias');
    }
}