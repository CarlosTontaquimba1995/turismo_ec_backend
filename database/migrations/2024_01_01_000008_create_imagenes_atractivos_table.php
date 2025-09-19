<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_atractivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atractivo_id')->constrained('atractivos')->onDelete('cascade');
            $table->text('url');
            $table->text('descripcion')->nullable();
            $table->boolean('es_principal')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->auditable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_atractivos');
    }
};
