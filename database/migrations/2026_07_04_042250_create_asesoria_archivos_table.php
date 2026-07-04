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
        Schema::create('asesoria_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesoria_id')->constrained('asesorias')->onDelete('cascade');
            $table->string('nombre_archivo');
            $table->string('ruta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesoria_archivos');
    }
};
