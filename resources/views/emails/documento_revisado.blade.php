<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Revisión de Documento</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9fafb; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0056b3; padding-bottom: 15px; }
        .header h1 { color: #0056b3; margin: 0; }
        .content { margin-bottom: 20px; }
        .status-aprobado { color: #059669; font-weight: bold; }
        .status-rechazado { color: #dc2626; font-weight: bold; }
        .feedback { background-color: #f3f4f6; padding: 15px; border-left: 4px solid #0056b3; margin-top: 15px; font-style: italic; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.85em; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #0056b3; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistema de Residencias UTGZ</h1>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $documento->alumno->user->name }}</strong>,</p>
            
            <p>Tu asesor ha revisado tu documento correspondiente a la <strong>Etapa {{ $documento->etapa_id }}</strong>.</p>
            
            <p>Estado de la revisión: 
                @if($documento->estado === \App\Enums\DocumentoEstado::Aprobado)
                    <span class="status-aprobado">APROBADO</span>
                @else
                    <span class="status-rechazado">RECHAZADO</span>
                @endif
            </p>

            @if($documento->retroalimentacion)
                <div class="feedback">
                    <strong>Comentarios del asesor:</strong><br>
                    {{ $documento->retroalimentacion }}
                </div>
            @endif

            <p style="text-align: center;">
                <a href="{{ config('app.url') }}/alumno/dashboard" class="btn">Ingresar al Sistema</a>
            </p>
        </div>

        <div class="footer">
            Este es un correo automático generado por el Sistema de Registro y Seguimiento de Residencias Profesionales de la UTGZ. Por favor, no respondas a esta dirección.
        </div>
    </div>
</body>
</html>
