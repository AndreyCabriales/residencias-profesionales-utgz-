<?php

namespace App\Repositories\Contracts;

use App\Models\Alumno;

interface AlumnoRepositoryInterface
{
    public function findById(int $id): ?Alumno;
    public function findByUserId(int $userId): ?Alumno;
    public function updateEtapa(int $alumnoId, int $nuevaEtapaId): bool;
}
