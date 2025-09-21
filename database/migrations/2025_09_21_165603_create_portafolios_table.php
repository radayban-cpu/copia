<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('portafolios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('url_imagen');
            $table->foreignId('categoria_id')->constrained('categorias_portafolio')->onDelete('cascade');
            $table->foreignId('dato_personal_id')->constrained('datos_personales')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('portafolios');
    }
};