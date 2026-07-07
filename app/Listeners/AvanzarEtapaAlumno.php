<?php

namespace App\Listeners;

use App\Events\DocumentoRevisado;
use App\Enums\DocumentoEstado;
use App\Repositories\Contracts\AlumnoRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AvanzarEtapaAlumno
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected AlumnoRepositoryInterface $alumnoRepository
    ) {}

    /**
     * Handle the event.
     */
    public function handle(DocumentoRevisado $event): void
    {
        $documento = $event->documento;
        $alumno = $documento->alumno;

        // Registrar en el Activity Log
        $estadoTexto = $documento->estado === DocumentoEstado::Aprobado ? 'aprobado' : 'rechazado';
        activity()
            ->performedOn($documento)
            ->event('documento_revisado')
            ->log("El documento {$documento->etapa->nombre} ha sido {$estadoTexto}.");

        // Si el documento fue aprobado, verificamos si el alumno ya completó todas las fases
        if ($documento->estado === DocumentoEstado::Aprobado) {
            $procesoService = app(\App\Services\ProcesoEstadiaService::class);
            $faseActual = $procesoService->getFaseActual($alumno);

            if ($faseActual === 5 && $alumno->estado_residencia !== \App\Enums\ResidenciaEstado::Finalizada) {
                // Completó la Fase 4 (todas las obligatorias)
                $alumno->estado_residencia = \App\Enums\ResidenciaEstado::Finalizada;
                $alumno->fecha_finalizacion = now();
                $alumno->save();
                
                activity()
                    ->performedOn($alumno)
                    ->event('proceso_finalizado')
                    ->log('El alumno ha completado todas las fases de estadía profesional.');
            }
        }
    }
}
