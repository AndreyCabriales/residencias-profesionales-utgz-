<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesoria;
use App\Models\Alumno;
use App\Repositories\Contracts\AsesoriaRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AsesoriaController extends Controller
{
    protected $asesoriaRepo;

    public function __construct(AsesoriaRepositoryInterface $asesoriaRepo)
    {
        $this->asesoriaRepo = $asesoriaRepo;
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'required|date',
            'duracion' => 'required|integer|min:15',
            'modalidad' => 'required|in:Presencial,Virtual',
            'lugar' => 'nullable|string',
            'recurrencia' => 'nullable|string'
        ]);

        $user = $request->user();
        if (!$user->hasRole('asesor') || !$user->asesor) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $data = $request->all();
        $data['asesor_id'] = $user->asesor->id;
        $data['estado'] = 'Pendiente'; // Estado inicial para que el alumno confirme
        $data['provider'] = config('services.videocalls.provider', env('VIDEOCALL_PROVIDER', 'jitsi'));

        // Generar enlace si es Virtual
        if ($data['modalidad'] === 'Virtual') {
            $alumno = Alumno::find($data['alumno_id']);
            $uuid = Str::upper(Str::random(5));
            $baseUrl = config('services.jitsi.url', env('JITSI_BASE_URL', 'https://meet.jit.si'));
            $data['enlace'] = "{$baseUrl}/UTGZ-{$alumno->matricula}-{$uuid}";
        }

        $asesoria = $this->asesoriaRepo->create($data);

        return response()->json(['message' => 'Asesoría programada con éxito', 'asesoria' => $asesoria], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $asesoria = $this->asesoriaRepo->findById($id);
        if (!$asesoria) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        $this->authorize('update', $asesoria);

        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'fecha_hora' => 'sometimes|date',
            'duracion' => 'sometimes|integer|min:15',
            'estado' => 'sometimes|in:Pendiente,Aceptada,Rechazada,Reprogramacion,Programada,Completada,Cancelada',
            'observaciones' => 'sometimes|nullable|string'
        ]);

        $this->asesoriaRepo->update($id, $request->all());

        return response()->json(['message' => 'Asesoría actualizada']);
    }

    public function destroy($id): JsonResponse
    {
        $asesoria = $this->asesoriaRepo->findById($id);
        if (!$asesoria) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        $this->authorize('delete', $asesoria);

        $this->asesoriaRepo->delete($id);

        return response()->json(['message' => 'Asesoría eliminada']);
    }
}
