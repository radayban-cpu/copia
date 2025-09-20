<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('habilidades', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 255);
        $table->integer('nivel')->nullable(); // Ejemplo: porcentaje o nivel de dominio (0-100)

        // FKs
        $table->foreignId('dato_personal_id')
              ->constrained('datos_personales')
              ->onDelete('cascade');

        $table->foreignId('tipo_habilidad_id')
              ->constrained('tipos_habilidades')
              ->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habilidades');
    }
};
