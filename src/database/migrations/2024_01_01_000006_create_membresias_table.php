<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membresias', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `miembro_id` INT UNSIGNED NOT NULL
            $table->foreignId('miembro_id')
                  ->constrained('miembros') // CONSTRAINT `fk_membresias_miembro_id` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`)
                  ->onDelete('cascade')   // ON DELETE CASCADE
                  ->onUpdate('cascade');  // ON UPDATE CASCADE

            // `tipo_membresia_id` INT UNSIGNED NOT NULL
            $table->foreignId('tipo_membresia_id')
                  ->constrained('tipos_membresia') // CONSTRAINT `fk_membresias_tipo_membresia_id` FOREIGN KEY (`tipo_membresia_id`) REFERENCES `tipos_membresia` (`id`)
                  ->onDelete('restrict') // ON DELETE RESTRICT
                  ->onUpdate('cascade'); // ON UPDATE CASCADE

            $table->date('fecha_inicio'); // DATE NOT NULL
            $table->date('fecha_fin');    // DATE NOT NULL

            // `estado` ENUM('Activa', 'Vencida', 'Cancelada', 'Pendiente de Pago') NOT NULL DEFAULT 'Pendiente de Pago'
            // Mapeado a string. Alternativa: $table->enum('estado', ['Activa', 'Vencida', 'Cancelada', 'Pendiente de Pago'])->default('Pendiente de Pago');
            $table->string('estado', 20)->default('Pendiente de Pago');

            $table->decimal('precio_pagado', 10, 2)->nullable(); // DECIMAL(10, 2) NULL DEFAULT NULL
            $table->text('notas')->nullable(); // TEXT NULL DEFAULT NULL
            $table->boolean('renovacion_automatica')->default(false); // BOOLEAN NOT NULL DEFAULT FALSE

            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            // INDEX `idx_membresias_miembro_id` (`miembro_id`) es creado por constrained()
            // INDEX `idx_membresias_tipo_membresia_id` (`tipo_membresia_id`) es creado por constrained()
            $table->index('fecha_fin', 'idx_membresias_fecha_fin'); // INDEX `idx_membresias_fecha_fin` (`fecha_fin`)
            $table->index('estado', 'idx_membresias_estado');       // INDEX `idx_membresias_estado` (`estado`)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
