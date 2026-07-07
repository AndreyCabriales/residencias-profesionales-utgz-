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
        Schema::table('calendario_academicos', function (Blueprint $table) {
            $table->dropColumn('tipo_evento');
            $table->foreignId('catalogo_tipo_evento_id')->nullable()->constrained('catalogo_items')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendario_academicos', function (Blueprint $table) {
            $table->dropForeign(['catalogo_tipo_evento_id']);
            $table->dropColumn('catalogo_tipo_evento_id');
            $table->enum('tipo_evento', ['Entrega', 'Reunion', 'Evento Institucional'])->default('Evento Institucional');
        });
    }
};
