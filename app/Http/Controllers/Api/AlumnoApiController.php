<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Alumno;
use App\Enums\ResidenciaEstado;
use Illuminate\Http\JsonResponse;

class AlumnoApiController extends Controller
{
    /**
     * Devuelve estadísticas y lista de alumnos activos para uso en dashboards.
     */
    public function stats(): JsonResponse
    {
        $alumnos = Alumno::with(['user', 'etapa', 'companyAdvisor'])->get();

        $enProceso = $alumnos->where('estado_residencia', ResidenciaEstado::EnProceso)->count();
        $finalizados = $alumnos->where('estado_residencia', ResidenciaEstado::Finalizada)->count();

        $data = $alumnos->map(function ($alumno) {
            return [
                'id' => $alumno->id,
                'nombre' => $alumno->user->name ?? 'Desconocido',
                'matricula' => $alumno->matricula,
                'carrera' => $alumno->carrera,
                'empresa' => $alumno->companyAdvisor->empresa ?? 'No asignada',
                'estado' => $alumno->estado_residencia->value,
                'etapa_actual' => $alumno->etapa->nombre ?? 'N/A'
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'message' => 'Estadísticas de alumnos recuperadas correctamente.',
            'meta' => [
                'total_alumnos' => $alumnos->count(),
                'en_proceso' => $enProceso,
                'finalizados' => $finalizados,
            ],
            'data' => $data
        ], 200);
    }
}
