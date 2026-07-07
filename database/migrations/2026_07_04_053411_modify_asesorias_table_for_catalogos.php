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
        Schema::table('asesorias', function (Blueprint $table) {
            $table->dropColumn(['modalidad', 'estado', 'provider']);
            $table->renameColumn('observaciones', 'resumen_final');
            
            $table->foreignId('catalogo_modalidad_id')->nullable()->constrained('catalogo_items')->onDelete('set null');
            $table->foreignId('catalogo_estado_id')->nullable()->constrained('catalogo_items')->onDelete('set null');
            $table->foreignId('catalogo_resultado_id')->nullable()->constrained('catalogo_items')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesorias', function (Blueprint $table) {
            $table->dropForeign(['catalogo_modalidad_id']);
            $table->dropForeign(['catalogo_estado_id']);
            $table->dropForeign(['catalogo_resultado_id']);
            
            $table->dropColumn(['catalogo_modalidad_id', 'catalogo_estado_id', 'catalogo_resultado_id']);
            
            $table->renameColumn('resumen_final', 'observaciones');
            $table->enum('modalidad', ['Presencial', 'Virtual'])->default('Virtual');
            $table->enum('estado', ['Pendiente', 'Aceptada', 'Rechazada', 'Reprogramacion', 'Programada', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->string('provider')->default('jitsi');
        });
    }
};
