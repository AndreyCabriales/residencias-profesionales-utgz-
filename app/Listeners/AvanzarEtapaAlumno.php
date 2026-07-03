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

        // Si el documento fue aprobado, el alumno avanza a la siguiente etapa
        if ($documento->estado === DocumentoEstado::Aprobado) {
            
            // Supongamos que las etapas son secuenciales (1, 2, 3...)
            // En la vida real aquí verificaríamos en la BD cuál es la etapa "siguiente"
            // Por simplicidad del modelo actual, le sumamos 1 a su etapa_id.
            $nuevaEtapa = $documento->etapa_id + 1;
            
            // Usamos el repositorio para actualizar al alumno
            $this->alumnoRepository->updateEtapa($documento->alumno_id, $nuevaEtapa);
        }
    }
}
