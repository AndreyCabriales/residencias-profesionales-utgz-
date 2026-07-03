<?php

namespace App\Policies;

use App\Models\Documento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentoPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Documento $documento): bool
    {
        // Si el usuario es el alumno dueño del documento, puede verlo
        if ($user->hasRole('alumno') && $user->alumno && $user->alumno->id === $documento->alumno_id) {
            return true;
        }

        // Si el usuario es el asesor asignado al alumno, puede verlo
        if ($user->hasRole('asesor') && $user->asesor) {
            $asignacion = $documento->alumno->asignacion;
            if ($asignacion && $asignacion->asesor_id === $user->asesor->id) {
                return true;
            }
        }

        // Si el usuario es coordinador, puede verlo todo
        if ($user->hasRole('coordinador')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can review the model (approve/reject).
     */
    public function review(User $user, Documento $documento): bool
    {
        // Solo el asesor asignado puede revisar el documento
        if ($user->hasRole('asesor') && $user->asesor) {
            $asignacion = $documento->alumno->asignacion;
            if ($asignacion && $asignacion->asesor_id === $user->asesor->id) {
                return true;
            }
        }

        return false;
    }
}
