<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Enums\DocumentoEstado;
use App\Events\DocumentoRevisado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AsesorDocumentoController extends Controller
{
    public function __construct(
        protected DocumentoRepositoryInterface $documentoRepository
    ) {}

    public function descargar(int $id)
    {
        $documento = $this->documentoRepository->findById($id);

        if (!$documento) {
            abort(404, 'Documento no encontrado');
        }

        // Verificar que el archivo exista en storage/app/documentos (disco local)
        if (!Storage::disk('local')->exists($documento->archivo)) {
            abort(404, 'El archivo físico no se encuentra en el servidor.');
        }

        return Storage::disk('local')->download($documento->archivo);
    }

    public function revisar(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'accion' => 'required|in:aprobar,rechazar',
            'retroalimentacion' => 'nullable|string|max:1000'
        ]);

        $documento = $this->documentoRepository->findById($id);
        
        if (!$documento) {
            return back()->with('error', 'Documento no encontrado.');
        }

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
