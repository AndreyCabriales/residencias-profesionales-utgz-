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

        // Si el documento fue aprobado, el alumno avanza a la siguiente etapa o finaliza
        if ($documento->estado === DocumentoEstado::Aprobado) {
            
            $etapaActual = $documento->etapa;
            $maxOrden = \App\Models\Etapa::where('activo', true)->max('orden');
            
            if ($etapaActual->orden >= $maxOrden) {
                // Es la última etapa, finalizar residencia
                $alumno = $documento->alumno;
                $alumno->estado_residencia = \App\Enums\ResidenciaEstado::Finalizada;
                $alumno->fecha_finalizacion = now();
                $alumno->save();
            } else {
                // Avanzar a la siguiente etapa (buscamos la etapa con el siguiente orden)
                $siguienteEtapa = \App\Models\Etapa::where('activo', true)
                    ->where('orden', '>', $etapaActual->orden)
                    ->orderBy('orden', 'asc')
                    ->first();
                    
                if ($siguienteEtapa) {
                    $this->alumnoRepository->updateEtapa($documento->alumno_id, $siguienteEtapa->id);
                }
            }
        }
    }
}
