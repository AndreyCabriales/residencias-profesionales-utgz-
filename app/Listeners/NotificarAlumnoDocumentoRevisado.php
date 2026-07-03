<?php

namespace App\Listeners;

use App\Events\DocumentoRevisado;
use App\Services\NotificacionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificarAlumnoDocumentoRevisado
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected NotificacionService $notificacionService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(DocumentoRevisado $event): void
    {
        // Enviar la notificación a través del servicio
        $this->notificacionService->notificarRevisionDocumento($event->documento);
    }
}
