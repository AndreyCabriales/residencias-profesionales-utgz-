<?php

namespace App\Policies;

use App\Enums\DocumentoEstado;
use App\Models\Asignacion;
use App\Models\Documento;
use App\Models\User;

class DocumentoPolicy
{
    /**
     * Determina si el usuario puede visualizar el documento.
     */
    public function view(User $user, Documento $documento): bool
    {
        // El Coordinador tiene acceso completo de lectura
        if ($user->hasRole('coordinador')) {
            return true;
        }

        // El Alumno solo puede visualizar sus propios documentos
        if ($user->hasRole('alumno')) {
            return $user->alumno && $user->alumno->id === $documento->alumno_id;
        }

        // Servicios Escolares solo visualiza documentos de su competencia
        if ($user->hasRole('servicios_escolares')) {
            return $documento->etapa->tipo === 'servicios_escolares';
        }

        // El Asesor solo puede visualizar documentos académicos de sus alumnos asignados
        if ($user->hasRole('asesor')) {
            if (!$user->asesor || $documento->etapa->tipo !== 'asesor') {
                return false;
            }
            return Asignacion::where('asesor_id', $user->asesor->id)
                ->where('alumno_id', $documento->alumno_id)
                ->exists();
        }

        return false;
    }

    /**
     * Determina si el usuario puede actualizar el documento.
     */
    public function update(User $user, Documento $documento): bool
    {
        // Solo aplica a Alumnos
        if (!$user->hasRole('alumno') || !$user->alumno) {
            return false;
        }

        // Debe pertenecerle al alumno
        if ($user->alumno->id !== $documento->alumno_id) {
            return false;
        }

        // Solo se puede editar si está Pendiente o Rechazado (No En Revisión ni Aprobado)
        return in_array($documento->estado, [
            DocumentoEstado::Pendiente,
            DocumentoEstado::Rechazado
        ], true);
    }

    // El método delete ha sido removido porque los documentos ya no pueden
    // ser eliminados por el alumno en este flujo de negocio.

    /**
     * Determina si el usuario puede evaluar (revisar) el documento.
     */
    public function evaluate(User $user, Documento $documento): bool
    {
        // El coordinador NO participa en evaluaciones
        if ($user->hasRole('coordinador')) {
            return false;
        }

        // El documento debe estar En Revisión
        if ($documento->estado !== DocumentoEstado::EnRevision) {
            return false;
        }

        // Si es Servicios Escolares, la etapa debe corresponderle
        if ($user->hasRole('servicios_escolares')) {
            return $documento->etapa->tipo === 'servicios_escolares';
        }

        // Si es Asesor, debe ser académico y debe estarle asignado
        if ($user->hasRole('asesor')) {
            if (!$user->asesor || $documento->etapa->tipo !== 'asesor') {
                return false;
            }

            return Asignacion::where('asesor_id', $user->asesor->id)
                ->where('alumno_id', $documento->alumno_id)
                ->exists();
        }

        return false;
    }
}
