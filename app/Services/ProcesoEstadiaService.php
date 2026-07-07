<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Etapa;
use App\Models\Documento;
use App\Enums\DocumentoEstado;

class ProcesoEstadiaService
{
    /**
     * Calcula y retorna la fase actual (1, 2, 3 o 4) del alumno.
     * Retorna 5 si todas las fases están completas.
     */
    public function getFaseActual(Alumno $alumno): int
    {
        // Revisamos fase por fase en orden
        for ($fase = 1; $fase <= 4; $fase++) {
            if (!$this->faseCompletada($alumno, $fase)) {
                return $fase;
            }
        }
        
        // Si completó las 4 fases
        return 5;
    }

    /**
     * Verifica si una fase en particular está completada.
     */
    public function faseCompletada(Alumno $alumno, int $faseId): bool
    {
        // Regla especial: Si es fase 2, se completa solo si el asesor la finalizó
        if ($faseId === 2) {
            return $alumno->seguimiento_finalizado;
        }

        // Para otras fases, buscamos todos los requerimientos OBLIGATORIOS de esa fase
        $etapasObligatorias = Etapa::where('fase_id', $faseId)
            ->where('tipo_regla', 'OBLIGATORIO')
            ->get();

        if ($etapasObligatorias->isEmpty()) {
            return true; // No hay obligatorios, consideramos la fase completa.
        }

        foreach ($etapasObligatorias as $etapa) {
            // Buscamos si el alumno tiene un documento aprobado para esta etapa
            $aprobado = Documento::where('alumno_id', $alumno->id)
                ->where('etapa_id', $etapa->id)
                ->where('estado', DocumentoEstado::Aprobado)
                ->exists();

            if (!$aprobado) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calcula el progreso general del alumno basado solo en reglas OBLIGATORIO.
     * Retorna un arreglo con el porcentaje, documentos aprobados y documentos totales.
     */
    public function calcularProgreso(Alumno $alumno): array
    {
        // Obtenemos todas las etapas OBLIGATORIAS
        $etapasObligatorias = Etapa::where('tipo_regla', 'OBLIGATORIO')->get();
        $total = $etapasObligatorias->count();
        
        if ($total === 0) {
            return [
                'porcentaje' => 100,
                'documentos_aprobados' => 0,
                'documentos_totales' => 0,
            ];
        }

        $completados = 0;

        foreach ($etapasObligatorias as $etapa) {
            $aprobado = Documento::where('alumno_id', $alumno->id)
                ->where('etapa_id', $etapa->id)
                ->where('estado', DocumentoEstado::Aprobado)
                ->exists();

            if ($aprobado) {
                $completados++;
            }
        }

        $porcentaje = round(($completados / $total) * 100);

        return [
            'porcentaje' => $porcentaje,
            'documentos_aprobados' => $completados,
            'documentos_totales' => $total,
        ];
    }

    /**
     * Verifica si el alumno tiene permitido subir un documento para una etapa específica.
     */
    public function puedeSubirDocumento(Alumno $alumno, Etapa $etapa): bool
    {
        $faseActual = $this->getFaseActual($alumno);

        // 1. La etapa no pertenece a la fase activa (el alumno no puede adelantarse o atrasarse en el proceso)
        // PERO puede ser que quiera reenviar un documento rechazado de una fase anterior que bloqueó el proceso.
        // Si la fase anterior no se completó, la fase actual ES esa fase anterior.
        // Así que si la etapa no es de la fase actual, lo bloqueamos.
        if ($etapa->fase_id !== $faseActual) {
            return false;
        }

        // 2. Si es fase 2 y ya está finalizada, bloqueamos 
        if ($etapa->fase_id === 2 && $alumno->seguimiento_finalizado) {
            return false;
        }

        // 3. Regla general para NO REPETIBLES: 
        // Si no es repetible, verificamos si ya existe uno Aprobado o En Revisión para no dejar subir otro.
        if ($etapa->tipo_regla !== 'REPETIBLE') {
            $existeDocBloqueante = Documento::where('alumno_id', $alumno->id)
                ->where('etapa_id', $etapa->id)
                ->whereIn('estado', [DocumentoEstado::Aprobado, DocumentoEstado::EnRevision])
                ->exists();
                
            if ($existeDocBloqueante) {
                return false;
            }
        }

        return true;
    }

    /**
     * Marca la fase 2 como finalizada por el Asesor.
     */
    public function finalizarSeguimiento(Alumno $alumno): void
    {
        $alumno->seguimiento_finalizado = true;
        $alumno->save();
        
        // Aquí se puede registrar en el Activity Log
        activity()
            ->performedOn($alumno)
            ->event('seguimiento_finalizado')
            ->log('El asesor académico ha finalizado la fase de seguimiento (reportes mensuales).');
    }
}
