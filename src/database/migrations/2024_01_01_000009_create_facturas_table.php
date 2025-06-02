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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `membresia_id` INT UNSIGNED NOT NULL
            $table->foreignId('membresia_id')
                  ->constrained('membresias') // CONSTRAINT `fk_facturas_membresia_id` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`)
                  ->onDelete('restrict')    // ON DELETE RESTRICT
                  ->onUpdate('cascade');     // ON UPDATE CASCADE

            $table->string('numero_factura', 50)->unique('uk_facturas_numero_factura'); // VARCHAR(50) NOT NULL, UNIQUE KEY
            $table->date('fecha_emision');    // DATE NOT NULL
            $table->date('fecha_vencimiento'); // DATE NOT NULL
            $table->decimal('monto_subtotal', 10, 2); // DECIMAL(10, 2) NOT NULL
            $table->decimal('impuestos', 10, 2)->default(0.00); // DECIMAL(10, 2) NOT NULL DEFAULT 0.00
            $table->decimal('monto_total', 10, 2); // DECIMAL(10, 2) NOT NULL

            // `estado` ENUM('Pendiente', 'Pagada', 'Vencida', 'Cancelada') NOT NULL DEFAULT 'Pendiente'
            // Mapeado a string. Alternativa: $table->enum('estado', ['Pendiente', 'Pagada', 'Vencida', 'Cancelada'])->default('Pendiente');
            $table->string('estado', 20)->default('Pendiente');

            $table->text('notas')->nullable(); // TEXT NULL DEFAULT NULL

            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            // INDEX `idx_facturas_membresia_id` (`membresia_id`) es creado por constrained()
            $table->index('estado', 'idx_facturas_estado'); // INDEX `idx_facturas_estado` (`estado`)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
