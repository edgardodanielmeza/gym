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
        Schema::create('dispositivos_acceso', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `sucursal_id` INT UNSIGNED NOT NULL
            $table->foreignId('sucursal_id')
                  ->constrained('sucursales') // CONSTRAINT `fk_dispositivos_acceso_sucursal_id` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
                  ->onDelete('cascade')     // ON DELETE CASCADE
                  ->onUpdate('cascade');    // ON UPDATE CASCADE

            $table->string('nombre_dispositivo', 100); // VARCHAR(100) NOT NULL

            // `tipo_dispositivo` ENUM('Torniquete', 'Puerta', 'Lector QR', 'Otro') NOT NULL
            // Mapeado a string. Alternativa: $table->enum('tipo_dispositivo', ['Torniquete', 'Puerta', 'Lector QR', 'Otro']);
            $table->string('tipo_dispositivo', 20);

            $table->string('ubicacion_descripcion', 255)->nullable(); // VARCHAR(255) NULL DEFAULT NULL
            $table->ipAddress('direccion_ip')->nullable(); // VARCHAR(45) NULL DEFAULT NULL
            $table->macAddress('mac_address')->nullable()->unique('uk_dispositivos_acceso_mac'); // VARCHAR(17) NULL DEFAULT NULL, UNIQUE KEY
            $table->boolean('activo')->default(true); // BOOLEAN NOT NULL DEFAULT TRUE

            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            // INDEX `idx_dispositivos_acceso_sucursal_id` (`sucursal_id`) es creado por constrained()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositivos_acceso');
    }
};
