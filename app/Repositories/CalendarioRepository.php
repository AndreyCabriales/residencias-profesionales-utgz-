<?php

namespace App\Repositories;

use App\Models\CalendarioAcademico;
use App\Repositories\Contracts\CalendarioRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CalendarioRepository implements CalendarioRepositoryInterface
{
    public function getEventosActivos(): Collection
    {
        return CalendarioAcademico::where('activo', true)
            ->orderBy('fecha_inicio', 'asc')
            ->get();
    }
}
