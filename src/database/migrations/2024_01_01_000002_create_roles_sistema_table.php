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
        Schema::create('roles_sistema', function (Blueprint $table) {
            $table->id(); // INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->string('nombre_rol', 50)->unique('uk_roles_sistema_nombre_rol'); // VARCHAR(50) NOT NULL, UNIQUE KEY
            $table->text('descripcion')->nullable(); // TEXT NULL DEFAULT NULL
            $table->timestamp('created_at')->useCurrent(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_sistema');
    }
};
