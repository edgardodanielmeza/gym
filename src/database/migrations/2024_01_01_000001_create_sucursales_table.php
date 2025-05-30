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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id(); // Corresponde a INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre', 100)->unique('uk_sucursales_nombre'); // VARCHAR(100) NOT NULL, UNIQUE KEY
            $table->string('direccion', 255); // VARCHAR(255) NOT NULL
            $table->string('telefono', 20)->nullable(); // VARCHAR(20) NULL DEFAULT NULL
            $table->string('email', 100)->nullable(); // VARCHAR(100) NULL DEFAULT NULL
            $table->time('horario_apertura')->nullable(); // TIME NULL DEFAULT NULL
            $table->time('horario_cierre')->nullable(); // TIME NULL DEFAULT NULL
            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
