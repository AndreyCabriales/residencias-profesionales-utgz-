<?php

namespace App\Events;

use App\Models\Documento;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentoRevisado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $documento;

    /**
     * Create a new event instance.
     */
    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
    }
}
