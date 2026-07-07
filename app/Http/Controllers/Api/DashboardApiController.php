<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProcesoEstadiaService;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    protected $procesoService;

    public function __construct(ProcesoEstadiaService $procesoService)
    {
        $this->procesoService = $procesoService;
    }

    public function progreso(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user || !$user->alumno) {
            return response()->json(['error' => 'Usuario no es alumno'], 403);
        }

        $alumno = $user->alumno;

        $faseActual = $this->procesoService->getFaseActual($alumno);
        $progreso = $this->procesoService->calcularProgreso($alumno);

        // Obtener etapas correspondientes a la fase actual que el alumno puede subir
        $etapasDisponibles = \App\Models\Etapa::where('fase_id', $faseActual)->get();

        return response()->json([
            'fase_actual' => $faseActual,
            'porcentaje' => $progreso['porcentaje'],
            'documentos_aprobados' => $progreso['documentos_aprobados'],
            'documentos_totales' => $progreso['documentos_totales'],
            'etapas_disponibles' => $etapasDisponibles,
        ]);
    }

    public function finalizarSeguimiento(Request $request): JsonResponse
    {
        // Esto lo llama el Asesor Académico para finalizar el seguimiento (Fase 2) de un alumno
        $user = $request->user();
        
        if (!$user || !$user->hasRole('asesor')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id'
        ]);

        $alumno = \App\Models\Alumno::findOrFail($request->alumno_id);

        // Validar que el asesor logueado esté asignado a este alumno (mitigación IDOR)
        $asignado = \App\Models\Asignacion::where('asesor_id', $user->asesor->id)
            ->where('alumno_id', $alumno->id)
            ->exists();

        if (!$asignado) {
            return response()->json(['error' => 'Alumno no asignado a este asesor'], 403);
        }

        $this->procesoService->finalizarSeguimiento($alumno);

        return response()->json(['message' => 'Fase de seguimiento finalizada con éxito']);
    }
}
