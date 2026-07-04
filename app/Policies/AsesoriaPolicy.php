<?php

namespace App\Policies;

use App\Models\Asesoria;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AsesoriaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['asesor', 'alumno', 'coordinador']);
    }

    public function view(User $user, Asesoria $Asesoria): bool
    {
        if ($user->hasRole('coordinador')) return true;
        
        if ($user->hasRole('asesor')) {
            return $user->asesor && $user->asesor->id === $Asesoria->asesor_id;
        }

        if ($user->hasRole('alumno')) {
            return $user->alumno && $user->alumno->id === $Asesoria->alumno_id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('asesor');
    }

    public function update(User $user, Asesoria $Asesoria): bool
    {
        return $user->hasRole('asesor') && $user->asesor && $user->asesor->id === $Asesoria->asesor_id;
    }

    public function delete(User $user, Asesoria $Asesoria): bool
    {
        return $user->hasRole('asesor') && $user->asesor && $user->asesor->id === $Asesoria->asesor_id;
    }
}
