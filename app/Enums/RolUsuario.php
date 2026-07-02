<?php

namespace App\Enums;

enum RolUsuario: string
{
    case Coordinador = 'coordinador';
    case Asesor = 'asesor';
    case Alumno = 'alumno';
    
    public function label(): string
    {
        return match($this) {
            self::Coordinador => 'Coordinador',
            self::Asesor => 'Asesor Académico',
            self::Alumno => 'Alumno',
        };
    }
}
