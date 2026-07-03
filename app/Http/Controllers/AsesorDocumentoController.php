<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Enums\DocumentoEstado;
use App\Events\DocumentoRevisado;
use App\Models\Documento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class AsesorDocumentoController extends Controller
{
    public function __construct(
        protected DocumentoRepositoryInterface $documentoRepository
    ) {}

    public function descargar(Documento $documento)
    {
        // Política de seguridad para prevenir IDOR
        Gate::authorize('view', $documento);

        // Verificar que el archivo exista en storage/app/documentos (disco local)
        if (!Storage::disk('local')->exists($documento->archivo)) {
            return redirect()->route('asesor.dashboard')
                ->with('error', 'El archivo físico no se encuentra en el servidor.');
        }

        return Storage::disk('local')->download($documento->archivo);
    }

    public function revisar(Request $request, Documento $documento): RedirectResponse
    {
        $request->validate([
            'accion' => 'required|in:aprobar,rechazar',
            'retroalimentacion' => 'nullable|string|max:1000'
        ]);

        // Política de seguridad para prevenir evaluación no autorizada
        Gate::authorize('evaluate', $documento);

        $nuevoEstado = $request->accion === 'aprobar' 
            ? DocumentoEstado::Aprobado 
            : DocumentoEstado::Rechazado;

        // Actualizar el estado en base de datos
        $exito = $this->documentoRepository->updateEstado(
            $documento->id, 
            $nuevoEstado, 
            $request->retroalimentacion
        );

        if ($exito) {
            // Refrescar el documento y disparar el evento
            $documento->refresh();
            event(new DocumentoRevisado($documento));

            $mensaje = $nuevoEstado === DocumentoEstado::Aprobado 
                ? 'Documento aprobado correctamente. El alumno ha avanzado de etapa.' 
                : 'Documento rechazado. El alumno deberá corregirlo.';
                
            return back()->with('success', $mensaje);
        }

        return back()->with('error', 'Hubo un problema al procesar la revisión.');
    }
}
