<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipos_imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_imagen');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tipos_imagenes');
    }
};