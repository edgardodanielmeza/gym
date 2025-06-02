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
        Schema::create('usuarios_sistema', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `sucursal_id` INT UNSIGNED NULL
            $table->foreignId('sucursal_id')
                  ->nullable()
                  ->constrained('sucursales') // CONSTRAINT `fk_usuarios_sistema_sucursal_id` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
                  ->onDelete('set null')     // ON DELETE SET NULL
                  ->onUpdate('cascade');    // ON UPDATE CASCADE

            // `rol_id` INT UNSIGNED NOT NULL
            $table->foreignId('rol_id')
                  ->constrained('roles_sistema') // CONSTRAINT `fk_usuarios_sistema_rol_id` FOREIGN KEY (`rol_id`) REFERENCES `roles_sistema` (`id`)
                  ->onDelete('restrict')   // ON DELETE RESTRICT
                  ->onUpdate('cascade');    // ON UPDATE CASCADE

            $table->string('nombre_usuario', 50)->unique('uk_usuarios_sistema_nombre_usuario'); // VARCHAR(50) NOT NULL, UNIQUE KEY
            $table->string('nombre_completo', 100); // VARCHAR(100) NOT NULL
            $table->string('email', 100)->unique('uk_usuarios_sistema_email'); // VARCHAR(100) NOT NULL, UNIQUE KEY
            $table->string('password', 255); // VARCHAR(255) NOT NULL (nombre cambiado de password_hash)
            $table->boolean('activo')->default(true); // BOOLEAN NOT NULL DEFAULT TRUE

            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            // Los índices idx_usuarios_sistema_sucursal_id y idx_usuarios_sistema_rol_id son creados automáticamente por constrained()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_sistema');
    }
};
