<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etapa;

class EtapaSeeder extends Seeder {
    public function run(): void {
        $etapas = [
            [
                'codigo' => 'FOR-06-12',
                'nombre' => 'Carta de Aceptación',
                'descripcion' => 'Documento emitido por la empresa aceptando al alumno.',
                'tipo' => 'servicios_escolares',
                'orden' => 1,
                'activo' => true
            ],
            [
                'codigo' => 'FOR-06-13',
                'nombre' => 'Reporte Parcial',
                'descripcion' => 'Reporte a la mitad de la estadía.',
                'tipo' => 'asesor',
                'orden' => 2,
                'activo' => true
            ],
            [
                'codigo' => 'FOR-06-14',
                'nombre' => 'Reporte Final',
                'descripcion' => 'Reporte de conclusión de la estadía.',
                'tipo' => 'asesor',
                'orden' => 3,
                'activo' => true
            ],
            [
                'codigo' => 'FOR-06-10',
                'nombre' => 'Evaluación Final',
                'descripcion' => 'Evaluación del desempeño realizada por la empresa.',
                'tipo' => 'servicios_escolares',
                'orden' => 4,
                'activo' => true
            ],
        ];

        foreach ($etapas as $etapa) {
            Etapa::create($etapa);
        }
    }
}