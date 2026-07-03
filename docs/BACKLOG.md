# Backlog v2: Sistema de Residencias UTGZ

Esta es una lista de funcionalidades avanzadas, proyecciones e ideas a futuro que complementan el sistema base, para ser implementadas en etapas posteriores al lanzamiento MVP.

## 1. Módulo de Calendario y Avisos
- **Calendario Global:** Un calendario incrustado (tipo FullCalendar) en el dashboard del Coordinador y Asesor para visualizar las fechas límite de entrega de reportes.
- **Recordatorios Automáticos:** Sistema de cronjobs (`php artisan schedule:run`) para enviar notificaciones automáticas (email y app) a los alumnos 3 días antes de que venza un reporte bimensual.

## 2. Sistema de Chat en Tiempo Real (WebSockets)
- **Chat Asesor-Alumno:** Integración de Laravel Reverb o Pusher para permitir que el alumno y el asesor académico chateen en tiempo real respecto a dudas de los formatos sin depender de WhatsApp o Correos.
- **Historial y Evidencias:** Todo el chat queda guardado en base de datos (`messages`) para servir como evidencia del seguimiento dado por el Asesor.

## 3. Revisión de Documentos con Inteligencia Artificial
- **Pre-validación AI (Claude/GPT):** Integrar la API de Anthropic o OpenAI para hacer un primer filtro a los reportes subidos.
    - *Ejemplo:* La IA lee el "Reporte de Actividades" y verifica si la redacción es congruente y si cuenta con la firma/sello de la empresa (OCR).
- **Sugerencias de Corrección:** Si el documento es rechazado, la IA puede sugerir automáticamente la redacción del motivo de rechazo al Asesor para agilizar su trabajo.

## 4. Firmas Electrónicas y Reportes en PDF
- **Generación Automática:** Uso de `dompdf` o `snappy` para que el Coordinador genere automáticamente el expediente del alumno con todos sus datos ya llenados.
- **Firma Digital (e-Firma):** Permitir a los asesores y coordinadores firmar documentos directamente en la plataforma mediante un pad de firma digital o un certificado, dándole validez oficial interna.

## 5. App Móvil (PWA o Flutter)
- **APIs REST:** Evolucionar las rutas actuales a un set completo de APIs (`routes/api.php`) protegidas con Sanctum.
- **Progressive Web App (PWA):** Instalar el manifest y service workers para que los alumnos puedan instalar el sistema en sus teléfonos y recibir Push Notifications nativas.

## 6. Módulo de Empresas y Evaluaciones
- **Bolsa de Trabajo:** Una vez finalizada la residencia, permitir a las empresas registradas ver los perfiles de los egresados destacados y ofrecerles vacantes.
- **Evaluación Cruzada:** Encuestas de satisfacción obligatorias al final de la residencia (El alumno evalúa al asesor y a la empresa; la empresa evalúa al alumno y a la UTGZ).
