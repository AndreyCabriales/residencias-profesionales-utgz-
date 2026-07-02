<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etapa;

class EtapaSeeder extends Seeder {
    public function run(): void {
        $etapas = [
            ['nombre' => 'Carta de presentación', 'orden' => 1],
            ['nombre' => 'Reporte parcial', 'orden' => 2],
            ['nombre' => 'Reporte final', 'orden' => 3],
            ['nombre' => 'Evaluación', 'orden' => 4],
        ];

        foreach ($etapas as $etapa) {
            Etapa::create($etapa);
        }
    }
}