<?php

namespace App\Repositories;

use App\Models\Documento;
use App\Enums\DocumentoEstado;
use App\Repositories\Contracts\DocumentoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DocumentoRepository implements DocumentoRepositoryInterface
{
    public function create(array $data): Documento
    {
        return Documento::create($data);
    }

    public function findById(int $id): ?Documento
    {
        return Documento::find($id);
    }

    public function getByAlumnoAndEtapa(int $alumnoId, int $etapaId): Collection
    {
        return Documento::where('alumno_id', $alumnoId)
            ->where('etapa_id', $etapaId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateEstado(int $documentoId, DocumentoEstado $estado, ?string $retroalimentacion = null): bool
    {
        $documento = $this->findById($documentoId);
        
        if (!$documento) {
            return false;
        }

        $documento->estado = $estado;
        
        if ($retroalimentacion !== null) {
            $documento->retroalimentacion = $retroalimentacion;
        }
        
        return $documento->save();
    }

    public function getPendientesPorAsesor(int $asesorId): Collection
    {
        return Documento::whereHas('alumno.asignacion', function($query) use ($asesorId) {
            $query->where('asesor_id', $asesorId);
        })
        ->where('estado', DocumentoEstado::Pendiente)
        ->with(['alumno.user', 'etapa'])
        ->orderBy('created_at', 'asc')
        ->get();
    }
}
