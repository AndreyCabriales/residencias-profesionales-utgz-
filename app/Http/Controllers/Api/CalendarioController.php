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

        // Traer eventos institucionales (comunes para todos)
        $institucionales = $this->calendarioRepo->getEventosActivos();
        foreach ($institucionales as $ev) {
            $eventos[] = [
                'id' => 'inst_'.$ev->id,
                'title' => $ev->titulo,
                'start' => $ev->fecha_inicio->toIso8601String(),
                'end' => $ev->fecha_fin ? $ev->fecha_fin->toIso8601String() : null,
                'color' => $ev->color,
                'extendedProps' => [
                    'tipo' => $ev->tipo_evento,
                    'descripcion' => $ev->descripcion,
                    'creador' => $ev->creador->name ?? 'Sistema'
                ]
            ];
        }

        // Traer asesorías según el rol
        $asesorias = collect();
        if ($user->hasRole('asesor') && $user->asesor) {
            $asesorias = $this->asesoriaRepo->getPorAsesor($user->asesor->id);
        } elseif ($user->hasRole('alumno') && $user->alumno) {
            $asesorias = $this->asesoriaRepo->getPorAlumno($user->alumno->id);
        }

        foreach ($asesorias as $ase) {
            $fin = (clone $ase->fecha_hora)->addMinutes($ase->duracion);
            
            // Asignar colores según estado
            $color = '#10B981'; // Verde por defecto
            if ($ase->estado === 'Pendiente') $color = '#F59E0B'; // Naranja
            if ($ase->estado === 'Rechazada' || $ase->estado === 'Cancelada') $color = '#EF4444'; // Rojo
            if ($ase->estado === 'Reprogramacion') $color = '#8B5CF6'; // Morado

            $eventos[] = [
                'id' => 'ase_'.$ase->id,
                'title' => $ase->titulo,
                'start' => $ase->fecha_hora->toIso8601String(),
                'end' => $fin->toIso8601String(),
                'color' => $color,
                'extendedProps' => [
                    'tipo' => 'Asesoria',
                    'descripcion' => $ase->descripcion,
                    'modalidad' => $ase->modalidad,
                    'lugar' => $ase->lugar,
                    'enlace' => $ase->enlace,
                    'estado' => $ase->estado,
                    'alumno' => $ase->alumno->user->name ?? '',
                    'asesor' => $ase->asesor->user->name ?? '',
                ]
            ];
        }

        return response()->json($eventos);
    }
}
