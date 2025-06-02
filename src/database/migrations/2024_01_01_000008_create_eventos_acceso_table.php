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
        Schema::create('eventos_acceso', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `miembro_id` INT UNSIGNED NOT NULL
            $table->foreignId('miembro_id')
                  ->constrained('miembros') // CONSTRAINT `fk_eventos_acceso_miembro_id` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`)
                  ->onDelete('cascade')   // ON DELETE CASCADE
                  ->onUpdate('cascade');  // ON UPDATE CASCADE

            // `dispositivo_id` INT UNSIGNED NOT NULL
            $table->foreignId('dispositivo_id')
                  ->constrained('dispositivos_acceso') // CONSTRAINT `fk_eventos_acceso_dispositivo_id` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos_acceso` (`id`)
                  ->onDelete('restrict') // ON DELETE RESTRICT
                  ->onUpdate('cascade'); // ON UPDATE CASCADE

            $table->timestamp('timestamp_evento')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

            // `tipo_evento` ENUM('Entrada', 'Salida', 'Intento Fallido') NOT NULL
            // Mapeado a string. Alternativa: $table->enum('tipo_evento', ['Entrada', 'Salida', 'Intento Fallido']);
            $table->string('tipo_evento', 20);

            $table->boolean('acceso_permitido'); // BOOLEAN NOT NULL
            $table->string('motivo_denegacion', 255)->nullable(); // VARCHAR(255) NULL DEFAULT NULL

            // INDEX `idx_eventos_acceso_miembro_id` (`miembro_id`) es creado por constrained()
            // INDEX `idx_eventos_acceso_dispositivo_id` (`dispositivo_id`) es creado por constrained()
            $table->index('timestamp_evento', 'idx_eventos_acceso_timestamp_evento'); // INDEX `idx_eventos_acceso_timestamp_evento` (`timestamp_evento`)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_acceso');
    }
};
