<?php

namespace App\Enums;

enum ResidenciaEstado: string
{
    case EnProceso = 'en_proceso';
    case Finalizada = 'finalizada';

    public function label(): string
    {
        return match($this) {
            self::EnProceso => 'En Proceso',
            self::Finalizada => 'Finalizada',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EnProceso => 'blue',
            self::Finalizada => 'green',
        };
    }
}
