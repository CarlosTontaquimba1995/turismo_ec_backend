<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuentes', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('url')->nullable();
            $table->date('fecha_obtenido');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->auditable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuentes');
    }
};
