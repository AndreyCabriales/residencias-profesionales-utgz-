<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentoRequest;
use App\Services\DocumentoService;
use App\Repositories\Contracts\AlumnoRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AlumnoDocumentoController extends Controller
{
    public function __construct(
        protected DocumentoService $documentoService,
        protected AlumnoRepositoryInterface $alumnoRepository
    ) {}

    /**
     * Store a newly created document in storage.
     */
    public function store(StoreDocumentoRequest $request): RedirectResponse
    {
        try {
            // 1. Obtener al alumno actual
            $alumno = $this->alumnoRepository->findByUserId(Auth::id());
            
            if (!$alumno) {
                return back()->with('error', 'No se encontró el registro de alumno asociado a esta cuenta.');
            }

            // 2. Usar el servicio para subir y registrar el documento
            $this->documentoService->subirDocumento(
                $request->file('documento'),
                $alumno->id,
                $alumno->etapa_id
            );

            return back()->with('success', 'Documento subido correctamente. En espera de revisión por tu asesor.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al subir el documento: ' . $e->getMessage());
        }
    }
}
