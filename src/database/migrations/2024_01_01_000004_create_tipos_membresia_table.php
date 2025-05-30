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
        Schema::create('tipos_membresia', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre', 100)->unique('uk_tipos_membresia_nombre'); // VARCHAR(100) NOT NULL, UNIQUE KEY
            $table->text('descripcion')->nullable(); // TEXT NULL DEFAULT NULL
            $table->unsignedInteger('duracion_dias'); // INT UNSIGNED NOT NULL
            $table->decimal('precio', 10, 2); // DECIMAL(10, 2) NOT NULL
            $table->boolean('activa')->default(true); // BOOLEAN NOT NULL DEFAULT TRUE
            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_membresia');
    }
};
