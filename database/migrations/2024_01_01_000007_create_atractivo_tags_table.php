<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atractivo_tags', function (Blueprint $table) {
            $table->foreignId('atractivo_id')->constrained('atractivos')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->primary(['atractivo_id', 'tag_id']);
            $table->auditable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atractivo_tags');
    }
};
