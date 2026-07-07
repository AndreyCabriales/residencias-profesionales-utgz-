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
            'catalogo_modalidad_id' => 'required|exists:catalogo_items,id',
            'lugar' => 'nullable|string',
            'recurrencia' => 'nullable|string'
        ]);

        $user = $request->user();
        if (!$user->hasRole('asesor') || !$user->asesor) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $data = $request->all();
        $data['asesor_id'] = $user->asesor->id;
        
        $estadoPendiente = \App\Models\CatalogoItem::whereHas('catalogo', function($q) {
            $q->where('nombre', 'estado_asesoria');
        })->where('valor', 'pendiente')->first();
        
        $data['catalogo_estado_id'] = $estadoPendiente->id ?? null;

        $modalidadVirtual = \App\Models\CatalogoItem::whereHas('catalogo', function($q) {
            $q->where('nombre', 'modalidad_asesoria');
        })->where('valor', 'virtual')->first();

        // Generar enlace si es Virtual
        if ($data['catalogo_modalidad_id'] == ($modalidadVirtual->id ?? -1)) {
            $alumno = Alumno::find($data['alumno_id']);
            $uuid = Str::upper(Str::random(5));
            $baseUrl = config('services.jitsi.url', env('JITSI_BASE_URL', 'https://meet.jit.si'));
            $prefix = config('services.jitsi.prefix', env('JITSI_ROOM_PREFIX', 'UTGZ'));
            $data['enlace'] = "{$baseUrl}/{$prefix}-{$alumno->matricula}-{$uuid}";
        }

        $asesoria = $this->asesoriaRepo->create($data);

        \App\Services\GenericLogService::log(
            $asesoria,
            'Asesoría Programada',
            'Se ha programado una nueva asesoría.',
            ['duracion' => $data['duracion'], 'estado_inicial' => 'Pendiente']
        );

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
            'estado' => 'sometimes|string',
            'observaciones' => 'sometimes|nullable|string'
        ]);

        $data = $request->all();
        
        // Convertir string de estado a catalogo_estado_id
        if (isset($data['estado'])) {
            $estadoItem = \App\Models\CatalogoItem::whereHas('catalogo', function($q) {
                $q->where('nombre', 'estado_asesoria');
            })->where('valor', \Illuminate\Support\Str::slug($data['estado']))->first();
            
            if ($estadoItem) {
                $data['catalogo_estado_id'] = $estadoItem->id;
            }
            unset($data['estado']);
        }

        $this->asesoriaRepo->update($id, $data);

        return response()->json(['message' => 'Asesoría actualizada']);
    }

    public function confirmar(Request $request, $id): JsonResponse
    {
        $asesoria = $this->asesoriaRepo->findById($id);
        if (!$asesoria) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        $this->authorize('confirm', $asesoria);

        $estadoProgramada = \App\Models\CatalogoItem::whereHas('catalogo', function($q) {
            $q->where('nombre', 'estado_asesoria');
        })->where('valor', 'programada')->first();

        if ($estadoProgramada) {
            $this->asesoriaRepo->update($id, ['catalogo_estado_id' => $estadoProgramada->id]);
            
            \App\Services\GenericLogService::log(
                $asesoria,
                'Asesoría Confirmada',
                'El alumno ha confirmado la asistencia a la asesoría.',
                ['estado_nuevo' => 'Programada']
            );
        }

        return response()->json(['message' => 'Asesoría confirmada exitosamente']);
    }

    public function destroy($id): JsonResponse
    {
        $asesoria = $this->asesoriaRepo->findById($id);
        if (!$asesoria) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        // $this->authorize('delete', $asesoria); // Si hay policy

        $this->asesoriaRepo->delete($id);

        return response()->json(['message' => 'Asesoría eliminada']);
    }

    public function show($id): JsonResponse
    {
        $asesoria = Asesoria::with([
            'asesor.user', 
            'alumno.user', 
            'estado', 
            'modalidad', 
            'resultado',
            'comentarios.user',
            'activityLogs.user'
        ])->find($id);

        if (!$asesoria) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        return response()->json($asesoria);
    }

    public function storeComentario(Request $request, $id): JsonResponse
    {
        $asesoria = Asesoria::find($id);
        if (!$asesoria) {
            return response()->json(['error' => 'No encontrada'], 404);
        }

        $request->validate([
            'cuerpo' => 'required|string',
            'tipo' => 'nullable|string'
        ]);

        $comentario = $asesoria->comentarios()->create([
            'user_id' => auth()->id(),
            'cuerpo' => $request->cuerpo,
            'tipo' => $request->tipo ?? 'comentario'
        ]);

        return response()->json([
            'message' => 'Comentario agregado', 
            'comentario' => $comentario->load('user')
        ]);
    }
}
