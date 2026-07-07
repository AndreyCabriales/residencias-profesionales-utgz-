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

            $etapa = \App\Models\Etapa::findOrFail($request->etapa_id);

            // Validación de negocio: Usar el servicio para validar reglas por fase
            $procesoService = app(\App\Services\ProcesoEstadiaService::class);
            if (!$procesoService->puedeSubirDocumento($alumno, $etapa)) {
                return back()->with('error', 'No tienes permitido subir este documento en este momento o ya tienes uno pendiente.');
            }

            // 2. Usar el servicio para subir y registrar el documento
            $this->documentoService->subirDocumento(
                $request->file('documento'),
                $alumno->id,
                $etapa->id
            );

            // 3. Si la etapa es FOR-06-12, capturamos los datos de la empresa, asesor organizacional y proyecto
            if ($etapa->codigo === 'FOR-06-12' && $request->has('company_empresa')) {
                $request->validate([
                    'company_empresa' => 'required|string|max:255',
                    'company_nombre' => 'required|string|max:255',
                    'company_puesto' => 'required|string|max:255',
                    'company_telefono' => 'nullable|string|max:20',
                    'nombre_proyecto' => 'required|string|max:255',
                ]);

                \App\Models\CompanyAdvisor::updateOrCreate(
                    ['alumno_id' => $alumno->id],
                    [
                        'empresa' => $request->input('company_empresa'),
                        'nombre' => $request->input('company_nombre'),
                        'puesto' => $request->input('company_puesto'),
                        'telefono' => $request->input('company_telefono'),
                    ]
                );

                $alumno->update([
                    'nombre_proyecto' => $request->input('nombre_proyecto'),
                ]);
            }

            return back()->with('success', 'Documento subido correctamente. En espera de revisión por tu asesor.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al subir el documento: ' . $e->getMessage());
        }
    }

    // El método destroy ha sido eliminado ya que en el nuevo flujo los documentos
    // nacen directamente en estado EnRevision y no pueden ser eliminados por el alumno.
}
