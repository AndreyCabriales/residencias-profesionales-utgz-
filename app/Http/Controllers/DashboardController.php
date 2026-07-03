<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\AlumnoRepositoryInterface;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected AlumnoRepositoryInterface $alumnoRepository,
        protected DocumentoRepositoryInterface $documentoRepository
    ) {}

    public function coordinador()
    {
        // En una fase posterior crearemos el AsesorRepository y AlumnoRepository completos para estadísticas
        // Por ahora cargamos la vista directamente
        return view('coordinador.dashboard');
    }

    public function asesor()
    {
        $asesorId = Auth::user()->asesor->id ?? null;
        
        $documentosPendientes = [];
        if ($asesorId) {
            $documentosPendientes = $this->documentoRepository->getPendientesPorAsesor($asesorId);
        }

        return view('asesor.dashboard', compact('documentosPendientes'));
    }

    public function alumno()
    {
        $alumno = $this->alumnoRepository->findByUserId(Auth::id());
        
        $documentos = [];
        if ($alumno) {
            // Obtener los documentos de la etapa actual del alumno
            $documentos = $this->documentoRepository->getByAlumnoAndEtapa($alumno->id, $alumno->etapa_id);
        }

        return view('alumno.dashboard', compact('alumno', 'documentos'));
    }
}
