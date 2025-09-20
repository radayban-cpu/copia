<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('ruta', 255); // nombre de archivo o path
            $table->string('descripcion', 255)->nullable();

            // FKs
            $table->foreignId('dato_personal_id')
                  ->constrained('datos_personales')
                  ->onDelete('cascade');

            $table->foreignId('tipo_imagen_id')
                  ->constrained('tipos_imagenes')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
