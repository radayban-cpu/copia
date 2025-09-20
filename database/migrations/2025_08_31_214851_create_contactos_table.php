<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('valor', 255); // ej: email o número de teléfono

            // FKs
            $table->foreignId('dato_personal_id')
                  ->constrained('datos_personales')
                  ->onDelete('cascade');

            $table->foreignId('tipo_contacto_id')
                  ->constrained('tipos_contactos')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
