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
        Schema::table('etapas', function (Blueprint $table) {
            $table->integer('fase_id')->nullable()->after('id');
            $table->string('tipo_regla')->default('OBLIGATORIO')->after('fase_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->dropColumn(['fase_id', 'tipo_regla']);
        });
    }
};
