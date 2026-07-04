<?php

namespace App\Repositories\Contracts;

interface AsesoriaRepositoryInterface
{
    public function getPorAlumno(int $alumnoId);
    public function getPorAsesor(int $asesorId);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
