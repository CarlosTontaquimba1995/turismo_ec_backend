<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contactos_atractivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atractivo_id')->constrained('atractivos')->onDelete('cascade');
            $table->string('telefono', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('web', 200)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->auditable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactos_atractivos');
    }
};
