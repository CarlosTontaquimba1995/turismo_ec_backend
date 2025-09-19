<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atractivos', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->double('lat', 10, 8)->nullable();
            $table->double('lon', 11, 8)->nullable();
            $table->text('direccion')->nullable();
            $table->string('nivel_importancia', 50)->nullable();
            $table->string('estado', 50)->default('Activo');
            $table->foreignId('fuente_id')->nullable()->constrained('fuentes');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atractivos');
    }
};
