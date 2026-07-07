<?php

namespace App\Services;

use App\Models\Asesoria;
use App\Models\CatalogoItem;
use App\Repositories\Contracts\AsesoriaRepositoryInterface;

class AsesoriaService
{
    protected $asesoriaRepo;

    public function __construct(AsesoriaRepositoryInterface $asesoriaRepo)
    {
        $this->asesoriaRepo = $asesoriaRepo;
    }

    public function updateEstado(Asesoria $asesoria, string $nuevoEstadoValor, ?string $comentario = null)
    {
        $estado = CatalogoItem::whereHas("catalogo", function($q) {
            $q->where("nombre", "estado_asesoria");
        })->where("valor", $nuevoEstadoValor)->first();

        if ($estado) {
            $estadoAnterior = $asesoria->estado->nombre ?? "Desconocido";
            $asesoria->update(["catalogo_estado_id" => $estado->id]);

            GenericLogService::log(
                $asesoria,
                "Cambio de Estado",
                $comentario,
                ["estado_anterior" => $estadoAnterior, "nuevo_estado" => $estado->nombre]
            );

            if ($comentario) {
                $asesoria->comentarios()->create([
                    "user_id" => auth()->id(),
                    "tipo" => "comentario",
                    "cuerpo" => $comentario
                ]);
            }
        }
        
        return $asesoria;
    }
}

