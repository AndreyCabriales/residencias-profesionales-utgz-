<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Enums\DocumentoEstado;
use App\Models\Documento;

class ServiciosEscolaresController extends Controller
{
    public function __construct(
        protected DocumentoRepositoryInterface $documentoRepository
    ) {}

    public function dashboard()
    {
        $documentosPendientes = $this->documentoRepository->getPendientesServiciosEscolares();
        
        // También podemos obtener aprobados y rechazados globales de esta área
        $documentosAprobados = Documento::whereHas('etapa', function($query) {
                $query->where('tipo', 'servicios_escolares');
            })
            ->where('estado', DocumentoEstado::Aprobado)
            ->with(['alumno.user', 'etapa'])
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $documentosRechazados = Documento::whereHas('etapa', function($query) {
                $query->where('tipo', 'servicios_escolares');
            })
            ->where('estado', DocumentoEstado::Rechazado)
            ->with(['alumno.user', 'etapa'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('servicios_escolares.dashboard', compact('documentosPendientes', 'documentosAprobados', 'documentosRechazados'));
    }

    public function revisar(Request $request, Documento $documento)
    {
        $request->validate([
            'estado' => ['required', 'string', 'in:aprobado,rechazado'],
            'retroalimentacion' => ['nullable', 'string', 'max:1000']
        ]);

        $this->authorize('evaluate', $documento);

        $nuevoEstado = $request->estado === 'aprobado' 
            ? DocumentoEstado::Aprobado 
            : DocumentoEstado::Rechazado;

        $exito = $this->documentoRepository->updateEstado(
            $documento->id, 
            $nuevoEstado,
            $request->retroalimentacion
        );

        if ($exito) {
            $documento->refresh();
            event(new \App\Events\DocumentoRevisado($documento));
        }

        return redirect()->route('servicios_escolares.dashboard')
            ->with('status', 'Documento evaluado correctamente.');
    }
}
