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

            // Validación de negocio: Evitar dobles subidas si ya hay uno pendiente
            $tienePendiente = \App\Models\Documento::where('alumno_id', $alumno->id)
                ->where('etapa_id', $alumno->etapa_id)
                ->where('estado', \App\Enums\DocumentoEstado::EnRevision)
                ->exists();

            if ($tienePendiente) {
                return back()->with('error', 'Ya tienes un documento pendiente de revisión para esta etapa. Espera a que tu asesor lo califique.');
            }

            // 2. Usar el servicio para subir y registrar el documento
            $this->documentoService->subirDocumento(
                $request->file('documento'),
                $alumno->id,
                $alumno->etapa_id
            );

            // 3. Si la etapa es FOR-06-12, capturamos los datos de la empresa y asesor organizacional
            if ($alumno->etapa->codigo === 'FOR-06-12' && $request->has('company_empresa')) {
                $request->validate([
                    'company_empresa' => 'required|string|max:255',
                    'company_nombre' => 'required|string|max:255',
                    'company_puesto' => 'required|string|max:255',
                    'company_telefono' => 'nullable|string|max:20',
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
            }

            return back()->with('success', 'Documento subido correctamente. En espera de revisión por tu asesor.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al subir el documento: ' . $e->getMessage());
        }
    }

    // El método destroy ha sido eliminado ya que en el nuevo flujo los documentos
    // nacen directamente en estado EnRevision y no pueden ser eliminados por el alumno.
}
