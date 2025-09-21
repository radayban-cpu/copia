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
        Schema::table('datos_personales', function (Blueprint $table) {
            // Añadimos las 3 nuevas columnas
            $table->string('carrera')->nullable()->after('ciudad_domicilio');
            $table->string('frase')->nullable()->after('carrera');
            $table->integer('edad')->nullable()->after('frase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_personales', function (Blueprint $table) {
            // Esto permite deshacer la migración si es necesario
            $table->dropColumn(['carrera', 'frase', 'edad']);
        });
    }
};