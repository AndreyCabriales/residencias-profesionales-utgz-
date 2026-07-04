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
        Schema::create('asesorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesor_id')->constrained('asesores')->onDelete('cascade');
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->dateTime('fecha_hora');
            $table->integer('duracion')->default(60)->comment('Duración en minutos');
            $table->enum('modalidad', ['Presencial', 'Virtual']);
            $table->string('lugar')->nullable();
            $table->string('provider')->default('jitsi');
            $table->string('enlace')->nullable();
            $table->enum('estado', ['Pendiente', 'Aceptada', 'Rechazada', 'Reprogramacion', 'Programada', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->string('recurrencia')->nullable()->comment('Ej. semanal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesorias');
    }
};
