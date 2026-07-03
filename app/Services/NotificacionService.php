<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\Documento;
use App\Mail\DocumentoRevisadoMail;
use Illuminate\Support\Facades\Mail;
use Exception;

class NotificacionService
{
    /**
     * Enviar notificación interna y por correo al alumno cuando se revisa su documento.
     */
    public function notificarRevisionDocumento(Documento $documento): void
    {
        $estado = $documento->estado->label();
        $titulo = "Documento Revisado: {$estado}";
        $mensaje = "Tu asesor ha {$estado} tu documento de la Etapa {$documento->etapa_id}.";

        if ($documento->retroalimentacion) {
            $mensaje .= " Comentarios: " . $documento->retroalimentacion;
        }

        // 1. Crear notificación en la base de datos para la campanita
        Notificacion::create([
            'user_id' => $documento->alumno->user_id,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'leida' => false,
        ]);

        // 2. Enviar correo electrónico
        try {
            Mail::to($documento->alumno->user->email)->send(new DocumentoRevisadoMail($documento));
        } catch (Exception $e) {
            // Loguear el error de correo para no romper la aplicación si el SMTP falla
            \Illuminate\Support\Facades\Log::error("Fallo al enviar correo a {$documento->alumno->user->email}: " . $e->getMessage());
        }
    }
}
