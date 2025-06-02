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
        Schema::create('miembros', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `sucursal_predeterminada_id` INT UNSIGNED NOT NULL
            $table->foreignId('sucursal_predeterminada_id')
                  ->constrained('sucursales') // CONSTRAINT `fk_miembros_sucursal_predeterminada_id` FOREIGN KEY (`sucursal_predeterminada_id`) REFERENCES `sucursales` (`id`)
                  ->onDelete('restrict')    // ON DELETE RESTRICT
                  ->onUpdate('cascade');     // ON UPDATE CASCADE

            $table->string('numero_identificacion', 50)->nullable()->unique('uk_miembros_numero_identificacion'); // VARCHAR(50) NULL DEFAULT NULL, UNIQUE KEY
            $table->string('nombre', 100); // VARCHAR(100) NOT NULL
            $table->string('apellidos', 100); // VARCHAR(100) NOT NULL
            $table->date('fecha_nacimiento')->nullable(); // DATE NULL DEFAULT NULL

            // `genero` ENUM('Masculino', 'Femenino', 'Otro', 'Prefiero no decirlo') NULL DEFAULT NULL
            // Mapeado a string según la solicitud. Se pueden usar validaciones en la aplicación.
            // Alternativamente: $table->enum('genero', ['Masculino', 'Femenino', 'Otro', 'Prefiero no decirlo'])->nullable();
            $table->string('genero', 20)->nullable();

            $table->string('direccion', 255)->nullable(); // VARCHAR(255) NULL DEFAULT NULL
            $table->string('telefono', 20); // VARCHAR(20) NOT NULL
            $table->string('email', 100)->unique('uk_miembros_email'); // VARCHAR(100) NOT NULL, UNIQUE KEY
            $table->date('fecha_registro'); // DATE NOT NULL
            $table->string('foto_perfil_url', 255)->nullable(); // VARCHAR(255) NULL DEFAULT NULL
            $table->text('notas_adicionales')->nullable(); // TEXT NULL DEFAULT NULL
            $table->boolean('activo')->default(true); // BOOLEAN NOT NULL DEFAULT TRUE

            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            // INDEX `idx_miembros_sucursal_predeterminada_id` (`sucursal_predeterminada_id`) es creado por constrained()
            $table->index(['apellidos', 'nombre'], 'idx_miembros_apellidos_nombre'); // INDEX `idx_miembros_apellidos_nombre` (`apellidos`, `nombre`)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
