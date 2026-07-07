<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadoAsesoria = DB::table('catalogos')->insertGetId([
            'nombre' => 'estado_asesoria',
            'descripcion' => 'Estados del ciclo de vida de una asesoría',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $estados = ['Programada', 'En curso', 'Pendiente', 'Finalizada', 'Cancelada'];
        foreach ($estados as $i => $estado) {
            DB::table('catalogo_items')->insert([
                'catalogo_id' => $estadoAsesoria,
                'nombre' => $estado,
                'valor' => Str::slug($estado),
                'orden' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $resultadoAsesoria = DB::table('catalogos')->insertGetId([
            'nombre' => 'resultado_asesoria',
            'descripcion' => 'Resultado de la asesoría',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $resultados = ['Aprobada', 'Rechazada', 'Reprogramada', 'No asistió'];
        foreach ($resultados as $i => $resultado) {
            DB::table('catalogo_items')->insert([
                'catalogo_id' => $resultadoAsesoria,
                'nombre' => $resultado,
                'valor' => Str::slug($resultado),
                'orden' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $modalidad = DB::table('catalogos')->insertGetId([
            'nombre' => 'modalidad_asesoria',
            'descripcion' => 'Modalidades de la asesoría',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $modalidades = ['Presencial', 'Virtual', 'Híbrida'];
        foreach ($modalidades as $i => $mod) {
            DB::table('catalogo_items')->insert([
                'catalogo_id' => $modalidad,
                'nombre' => $mod,
                'valor' => Str::slug($mod),
                'orden' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $providers = DB::table('catalogos')->insertGetId([
            'nombre' => 'video_providers',
            'descripcion' => 'Proveedores de videollamada',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $provs = ['Jitsi', 'Meet', 'Zoom', 'Teams'];
        foreach ($provs as $i => $prov) {
            DB::table('catalogo_items')->insert([
                'catalogo_id' => $providers,
                'nombre' => $prov,
                'valor' => Str::slug($prov),
                'orden' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $tiposEvento = DB::table('catalogos')->insertGetId([
            'nombre' => 'tipos_evento',
            'descripcion' => 'Tipos de eventos institucionales',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $evts = ['Entrega', 'Conferencia', 'Hackathon', 'Semana Académica', 'Vacaciones', 'Reunión'];
        foreach ($evts as $i => $ev) {
            DB::table('catalogo_items')->insert([
                'catalogo_id' => $tiposEvento,
                'nombre' => $ev,
                'valor' => Str::slug($ev),
                'orden' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
