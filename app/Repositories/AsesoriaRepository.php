<?php

namespace App\Repositories;

use App\Models\Asesoria;
use App\Repositories\Contracts\AsesoriaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AsesoriaRepository implements AsesoriaRepositoryInterface
{
    public function getPorAlumno(int $alumnoId): Collection
    {
        return Asesoria::with('asesor.user')
            ->where('alumno_id', $alumnoId)
            ->orderBy('fecha_hora', 'asc')
            ->get();
    }

    public function getPorAsesor(int $asesorId): Collection
    {
        return Asesoria::with('alumno.user')
            ->where('asesor_id', $asesorId)
            ->orderBy('fecha_hora', 'asc')
            ->get();
    }

    public function findById(int $id): ?Asesoria
    {
        return Asesoria::find($id);
    }

    public function create(array $data): Asesoria
    {
        return Asesoria::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $Asesoria = $this->findById($id);
        if ($Asesoria) {
            return $Asesoria->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $Asesoria = $this->findById($id);
        if ($Asesoria) {
            return $Asesoria->delete();
        }
        return false;
    }
}
