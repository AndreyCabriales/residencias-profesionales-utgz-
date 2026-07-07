<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etapa;

class EtapaSeeder extends Seeder {
    public function run(): void {
        $etapas = [
            // FASE 1 - INICIO
            [
                'codigo' => 'FOR-06-01',
                'nombre' => 'Solicitud de estadía',
                'descripcion' => 'Solicitud y propuesta de estadías.',
                'tipo' => 'servicios_escolares',
                'orden' => 1,
                'activo' => true,
                'fase_id' => 1,
                'tipo_regla' => 'OBLIGATORIO'
            ],
            [
                'codigo' => 'FOR-06-04',
                'nombre' => 'Carta compromiso',
                'descripcion' => 'Carta compromiso del alumno.',
                'tipo' => 'servicios_escolares',
                'orden' => 2,
                'activo' => true,
                'fase_id' => 1,
                'tipo_regla' => 'OBLIGATORIO'
            ],
            [
                'codigo' => 'FOR-06-12',
                'nombre' => 'Carta de Aceptación',
                'descripcion' => 'Documento emitido por la empresa aceptando al alumno.',
                'tipo' => 'servicios_escolares',
                'orden' => 3,
                'activo' => true,
                'fase_id' => 1,
                'tipo_regla' => 'OBLIGATORIO'
            ],

            // FASE 2 - SEGUIMIENTO
            [
                'codigo' => 'REP-MENSUAL',
                'nombre' => 'Reportes Mensuales',
                'descripcion' => 'Reportes mensuales de seguimiento de la estadía.',
                'tipo' => 'asesor',
                'orden' => 4,
                'activo' => true,
                'fase_id' => 2,
                'tipo_regla' => 'REPETIBLE'
            ],

            // FASE 3 - CIERRE ACADÉMICO
            [
                'codigo' => 'FOR-06-14',
                'nombre' => 'Reporte Final',
                'descripcion' => 'Reporte de conclusión de la estadía.',
                'tipo' => 'asesor',
                'orden' => 5,
                'activo' => true,
                'fase_id' => 3,
                'tipo_regla' => 'OBLIGATORIO'
            ],
            [
                'codigo' => 'FOR-06-10',
                'nombre' => 'Evaluación Final',
                'descripcion' => 'Evaluación del desempeño realizada por la empresa.',
                'tipo' => 'asesor',
                'orden' => 6,
                'activo' => true,
                'fase_id' => 3,
                'tipo_regla' => 'OBLIGATORIO'
            ],

            // FASE 4 - LIBERACIÓN
            [
                'codigo' => 'FOR-06-13',
                'nombre' => 'Carta de Liberación',
                'descripcion' => 'Carta de liberación por parte de la empresa.',
                'tipo' => 'servicios_escolares',
                'orden' => 7,
                'activo' => true,
                'fase_id' => 4,
                'tipo_regla' => 'OBLIGATORIO'
            ],
            [
                'codigo' => 'FOR-10-03',
                'nombre' => 'Cédula Pre-egreso',
                'descripcion' => 'Formulario de cédula de pre-egreso.',
                'tipo' => 'servicios_escolares',
                'orden' => 8,
                'activo' => true,
                'fase_id' => 4,
                'tipo_regla' => 'OBLIGATORIO'
            ],
            [
                'codigo' => 'FOR-06-09',
                'nombre' => 'Encuesta Egresado',
                'descripcion' => 'Encuesta de satisfacción del egresado.',
                'tipo' => 'servicios_escolares',
                'orden' => 9,
                'activo' => true,
                'fase_id' => 4,
                'tipo_regla' => 'OBLIGATORIO'
            ],
        ];

        foreach ($etapas as $etapa) {
            Etapa::updateOrCreate(
                ['codigo' => $etapa['codigo']],
                $etapa
            );
        }
    }
}