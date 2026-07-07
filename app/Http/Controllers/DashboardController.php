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
        protected NotificacionRepositoryInterface $notificacionRepository,
        protected \App\Repositories\Contracts\AsesoriaRepositoryInterface $asesoriaRepository
    ) {}

    public function coordinador()
    {
        $totalAlumnos = \App\Models\Alumno::count();
        $totalAsesores = \App\Models\Asesor::count();
        $alumnosEnProceso = \App\Models\Alumno::where('estado_residencia', \App\Enums\ResidenciaEstado::EnProceso)->count();
        $alumnosFinalizados = \App\Models\Alumno::where('estado_residencia', \App\Enums\ResidenciaEstado::Finalizada)->count();
        
        $documentosPendientes = \App\Models\Documento::where('estado', \App\Enums\DocumentoEstado::EnRevision)->count();
        $documentosAprobados = \App\Models\Documento::where('estado', \App\Enums\DocumentoEstado::Aprobado)->count();
        $documentosRechazados = \App\Models\Documento::where('estado', \App\Enums\DocumentoEstado::Rechazado)->count();

        $actividadReciente = $this->notificacionRepository->getRecentActivity(5);

        return view('coordinador.dashboard', compact(
            'totalAlumnos',
            'totalAsesores',
            'alumnosEnProceso',
            'alumnosFinalizados',
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
        $totalAlumnosAsignados = 0;
        $totalDocumentosPorRevisar = 0;
        $asesoriasPendientes = collect();
        $totalAsesoriasPendientes = 0;
        $alumnosAsignadosList = [];

        if ($asesorId) {
            $documentosPendientes = $this->documentoRepository->getPendientesPorAsesor($asesorId);
            $totalDocumentosPorRevisar = count($documentosPendientes);
            $totalAlumnosAsignados = \App\Models\Asignacion::where('asesor_id', $asesorId)->count();
            
            $alumnosAsignadosList = \App\Models\Alumno::whereHas('asignacion', function($q) use ($asesorId) {
                $q->where('asesor_id', $asesorId);
            })->with('user')->get();

            $asesoriasPendientes = $this->asesoriaRepository->getPorAsesor($asesorId)
                ->filter(function ($a) {
                    return strtolower($a->estado->nombre ?? '') === 'pendiente';
                });
            $totalAsesoriasPendientes = $asesoriasPendientes->count();
        }

        return view('asesor.dashboard', compact(
            'documentosPendientes', 
            'totalAlumnosAsignados', 
            'totalDocumentosPorRevisar',
            'asesoriasPendientes',
            'totalAsesoriasPendientes',
            'alumnosAsignadosList'
        ));
    }

    public function alumno()
    {
        $alumno = \App\Models\Alumno::with(['etapa', 'asignacion.asesor.user', 'companyAdvisor'])
                    ->where('user_id', Auth::id())
                    ->first();
        
        $documentos = [];
        $tienePendiente = false;
        $asesoriasPendientes = collect();
        
        if ($alumno) {
            // Obtener los documentos de la etapa actual del alumno
            $documentos = $this->documentoRepository->getByAlumnoAndEtapa($alumno->id, $alumno->etapa_id);
            
            // Verificar si hay alguno pendiente (que ahora es EnRevision)
            $tienePendiente = collect($documentos)->contains('estado', \App\Enums\DocumentoEstado::EnRevision);
            
            $asesoriasPendientes = $this->asesoriaRepository->getPorAlumno($alumno->id)
                ->filter(function ($a) {
                    return strtolower($a->estado->nombre ?? '') === 'pendiente';
                });
        }

        return view('alumno.dashboard', compact('alumno', 'documentos', 'tienePendiente', 'asesoriasPendientes'));
    }
}
