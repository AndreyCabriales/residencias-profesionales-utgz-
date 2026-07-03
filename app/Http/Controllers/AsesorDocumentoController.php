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

    public function descargar(int $id)
    {
        $documento = $this->documentoRepository->findById($id);

        if (!$documento) {
            return redirect()->route('asesor.dashboard')->with('error', 'Documento no encontrado.');
        }
        
        // Política de seguridad para prevenir IDOR
        if (!Gate::allows('view', $documento)) {
            return redirect()->route('asesor.dashboard')
                ->with('error', 'Acceso denegado: Este documento no pertenece a uno de tus alumnos asignados.');
        }

        // Verificar que el archivo exista en storage/app/documentos (disco local)
        if (!Storage::disk('local')->exists($documento->archivo)) {
            return redirect()->route('asesor.dashboard')
                ->with('error', 'El archivo físico no se encuentra en el servidor.');
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

        // Política de seguridad para prevenir modificación de otros documentos
        if (!Gate::allows('review', $documento)) {
            return redirect()->route('asesor.dashboard')
                ->with('error', 'Acceso denegado: No tienes permisos para revisar este documento.');
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
