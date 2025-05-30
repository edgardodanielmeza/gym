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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY

            // `factura_id` INT UNSIGNED NOT NULL
            $table->foreignId('factura_id')
                  ->constrained('facturas') // CONSTRAINT `fk_pagos_factura_id` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`)
                  ->onDelete('restrict')  // ON DELETE RESTRICT
                  ->onUpdate('cascade');   // ON UPDATE CASCADE

            // `usuario_sistema_id` INT UNSIGNED NULL
            $table->foreignId('usuario_sistema_id')
                  ->nullable()
                  ->constrained('usuarios_sistema') // CONSTRAINT `fk_pagos_usuario_sistema_id` FOREIGN KEY (`usuario_sistema_id`) REFERENCES `usuarios_sistema` (`id`)
                  ->onDelete('set null')    // ON DELETE SET NULL
                  ->onUpdate('cascade');     // ON UPDATE CASCADE

            $table->dateTime('fecha_pago'); // DATETIME NOT NULL
            $table->decimal('monto_pagado', 10, 2); // DECIMAL(10, 2) NOT NULL

            // `metodo_pago` ENUM('Efectivo', 'Tarjeta de Crédito', 'Tarjeta de Débito', 'Transferencia Bancaria', 'Otro') NOT NULL
            // Mapeado a string. Alternativa: $table->enum('metodo_pago', ['Efectivo', ...]);
            $table->string('metodo_pago', 30);

            $table->string('referencia_pago', 100)->nullable(); // VARCHAR(100) NULL DEFAULT NULL
            $table->text('notas')->nullable(); // TEXT NULL DEFAULT NULL

            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            // INDEX `idx_pagos_factura_id` (`factura_id`) es creado por constrained()
            // INDEX `idx_pagos_usuario_sistema_id` (`usuario_sistema_id`) es creado por constrained()
            $table->index('fecha_pago', 'idx_pagos_fecha_pago');       // INDEX `idx_pagos_fecha_pago` (`fecha_pago`)
            $table->index('metodo_pago', 'idx_pagos_metodo_pago');   // INDEX `idx_pagos_metodo_pago` (`metodo_pago`)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
