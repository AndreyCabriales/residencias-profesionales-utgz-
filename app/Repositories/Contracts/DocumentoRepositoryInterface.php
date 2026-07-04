<?php

namespace App\Repositories\Contracts;

use App\Models\Documento;
use App\Enums\DocumentoEstado;
use Illuminate\Database\Eloquent\Collection;

interface DocumentoRepositoryInterface
{
    public function create(array $data): Documento;
    public function findById(int $id): ?Documento;
    public function getByAlumnoAndEtapa(int $alumnoId, int $etapaId): Collection;
    public function updateEstado(int $documentoId, DocumentoEstado $estado, ?string $retroalimentacion = null): bool;
    public function getPendientesPorAsesor(int $asesorId): Collection;
    public function getPendientesServiciosEscolares(): Collection;
}
