<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CalendarioRepositoryInterface;
use App\Repositories\Contracts\AsesoriaRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CalendarioController extends Controller
{
    protected $calendarioRepo;
    protected $asesoriaRepo;

    public function __construct(CalendarioRepositoryInterface $calendarioRepo, AsesoriaRepositoryInterface $asesoriaRepo)
    {
        $this->calendarioRepo = $calendarioRepo;
        $this->asesoriaRepo = $asesoriaRepo;
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $eventos = [];

        // 1. Obtener Eventos Institucionales
        $eventosInstitucionales = \App\Models\CalendarioAcademico::with('tipoEvento')->get();
        foreach ($eventosInstitucionales as $ev) {
            $eventos[] = [
                'id' => 'ev_'.$ev->id,
                'title' => $ev->titulo,
                'start' => $ev->fecha_inicio->toIso8601String(),
                'end' => $ev->fecha_fin ? $ev->fecha_fin->toIso8601String() : null,
                'color' => $ev->color,
                'extendedProps' => [
                    'tipo' => 'Institucional',
                    'tipoEvento' => $ev->tipoEvento->nombre ?? 'Evento',
                    'descripcion' => $ev->descripcion,
                    'creador' => $ev->creador->name ?? 'Sistema'
                ]
            ];
        }

        // Traer asesorías según el rol
        $asesorias = collect();
        if ($user->hasRole('coordinador')) {
            $asesorias = $this->asesoriaRepo->getAll();
        } elseif ($user->hasRole('asesor') && $user->asesor) {
            $asesorias = $this->asesoriaRepo->getPorAsesor($user->asesor->id);
        } elseif ($user->hasRole('alumno') && $user->alumno) {
            $asesorias = $this->asesoriaRepo->getPorAlumno($user->alumno->id);
        }

        foreach ($asesorias as $ase) {
            $fin = (clone $ase->fecha_hora)->addMinutes($ase->duracion);
            
            // Asignar colores según estado
            $color = '#10B981'; // Verde por defecto
            $estadoNombre = $ase->estado->nombre ?? 'Pendiente';
            
            if ($estadoNombre === 'Pendiente') $color = '#F59E0B'; // Naranja
            if ($estadoNombre === 'Cancelada') $color = '#EF4444'; // Rojo

            $eventos[] = [
                'id' => 'ase_'.$ase->id,
                'title' => $ase->titulo,
                'start' => $ase->fecha_hora->toIso8601String(),
                'end' => $fin->toIso8601String(),
                'color' => $color,
                'extendedProps' => [
                    'tipo' => 'Asesoria',
                    'descripcion' => $ase->descripcion,
                    'modalidad' => $ase->modalidad->nombre ?? '',
                    'lugar' => $ase->lugar,
                    'enlace' => $ase->enlace,
                    'estado' => $estadoNombre,
                    'resultado' => $ase->resultado->nombre ?? '',
                    'alumno' => $ase->alumno->user->name ?? '',
                    'asesor' => $ase->asesor->user->name ?? '',
                ]
            ];
        }

        return response()->json($eventos);
    }
}
