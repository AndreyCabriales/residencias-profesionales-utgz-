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
        Schema::table('alumnos', function (Blueprint $table) {
            $table->enum('estado_residencia', ['en_proceso', 'finalizada'])->default('en_proceso')->after('etapa_id');
            $table->timestamp('fecha_finalizacion')->nullable()->after('estado_residencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn(['estado_residencia', 'fecha_finalizacion']);
        });
    }
};
