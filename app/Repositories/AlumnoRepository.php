<?php

namespace App\Repositories;

use App\Models\Alumno;
use App\Repositories\Contracts\AlumnoRepositoryInterface;

class AlumnoRepository implements AlumnoRepositoryInterface
{
    public function findById(int $id): ?Alumno
    {
        return Alumno::find($id);
    }

    public function findByUserId(int $userId): ?Alumno
    {
        return Alumno::where('user_id', $userId)->first();
    }

    public function updateEtapa(int $alumnoId, int $nuevaEtapaId): bool
    {
        $alumno = $this->findById($alumnoId);
        
        if (!$alumno) {
            return false;
        }

        $alumno->etapa_id = $nuevaEtapaId;
        return $alumno->save();
    }
}
