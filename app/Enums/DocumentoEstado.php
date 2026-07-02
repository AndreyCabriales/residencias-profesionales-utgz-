<?php

namespace App\Enums;

enum DocumentoEstado: string
{
    case Pendiente = 'pendiente';
    case EnRevision = 'en_revision';
    case Aprobado = 'aprobado';
    case Rechazado = 'rechazado';

    public function label(): string
    {
        return match($this) {
            self::Pendiente => 'Pendiente de entrega',
            self::EnRevision => 'En revisión',
            self::Aprobado => 'Aprobado',
            self::Rechazado => 'Rechazado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pendiente => 'gray',
            self::EnRevision => 'blue',
            self::Aprobado => 'green',
            self::Rechazado => 'red',
        };
    }
}
