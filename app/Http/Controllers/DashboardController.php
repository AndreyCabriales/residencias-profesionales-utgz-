<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\AlumnoRepositoryInterface;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use App\Repositories\Contracts\NotificacionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected AlumnoRepositoryInterface $alumnoRepository,
        protected DocumentoRepositoryInterface $documentoRepository,
        protected NotificacionRepositoryInterface $notificacionRepository
    ) {}

    public function coordinador()
    {
        $totalAlumnos = \App\Models\Alumno::count();
        $totalAsesores = \App\Models\Asesor::count();
        
        $documentosPendientes = \App\Models\Documento::where('estado', \App\Enums\DocumentoEstado::Pendiente)->count();
        $documentosAprobados = \App\Models\Documento::where('estado', \App\Enums\DocumentoEstado::Aprobado)->count();
        $documentosRechazados = \App\Models\Documento::where('estado', \App\Enums\DocumentoEstado::Rechazado)->count();

        $actividadReciente = $this->notificacionRepository->getRecentActivity(5);

        return view('coordinador.dashboard', compact(
            'totalAlumnos',
            'totalAsesores',
            'documentosPendientes',
            'documentosAprobados',
            'documentosRechazados',
            'actividadReciente'
        ));
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
        $alumno = \App\Models\Alumno::with(['etapa', 'asignacion.asesor.user', 'companyAdvisor'])
                    ->where('user_id', Auth::id())
                    ->first();
        
        $documentos = [];
        $tienePendiente = false;
        
        if ($alumno) {
            // Obtener los documentos de la etapa actual del alumno
            $documentos = $this->documentoRepository->getByAlumnoAndEtapa($alumno->id, $alumno->etapa_id);
            
            // Verificar si hay alguno pendiente
            $tienePendiente = collect($documentos)->contains('estado', \App\Enums\DocumentoEstado::Pendiente);
        }

        return view('alumno.dashboard', compact('alumno', 'documentos', 'tienePendiente'));
    }
}
