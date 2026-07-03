# Estado del Proyecto: Sistema de Registro y Seguimiento de Residencias Profesionales UTGZ

## 1. Objetivo General
Construir una plataforma web escalable, segura y mantenible para digitalizar y automatizar el proceso de registro y seguimiento de residencias profesionales en la Universidad Tecnológica de Gutiérrez Zamora (UTGZ). El sistema debe funcionar como un producto profesional que facilite la comunicación y revisión de documentos entre Coordinadores, Asesores y Alumnos.

## 2. Estado Actual
**Sprint Actual:** Sprint 3 (Perfeccionamiento UI/UX, Dashboards y Datos Realistas)
**Progreso Global:** ~70%
**Rama Activa:** `feature/modulo-documentos` (Integrado)

## 3. Funcionalidades
### Terminadas (Sprint 1, 2 y 3)
## 2. Estado Actual del Proyecto (Cierre Funcional)
El proyecto ha alcanzado un **100% del núcleo funcional** acordado. Se ha cerrado el ciclo completo del alumno desde su registro hasta la liberación de sus residencias.

### ✅ Hitos Completados (Sprint Final)
1. **Módulo de Observaciones:** El asesor ahora puede dejar *feedback* obligatorio al rechazar un documento, y el alumno lo visualiza de forma destacada (banner rojo) en su dashboard para corregirlo.
2. **Finalización de Residencia:** Al aprobarse el documento de la última etapa (ej. Carta de Liberación), el sistema automáticamente cambia el estado del alumno a `Finalizada`, oculta el flujo de subida y muestra su comprobante de finalización con fecha.
3. **Métricas de Cierre:** El dashboard del coordinador ahora incluye la estadística en tiempo real de los alumnos que ya terminaron.
4. **Vulnerabilidades Críticas Selladas (IDOR):** Las policies validan asignaciones en tiempo real y el routing de archivos protege contra accesos no autorizados.

### ⏳ Pendientes / Fuera de Alcance Actual
- Generación de documentos PDF pre-llenados.
- Vista previa embebida del PDF sin descargar.
- SweetAlert2 para confirmaciones de borrado de archivos.
- Envío de correos SMTP reales (actualmente manejados por driver log). (Exportación).

## 4. Seguridad
- Implementación de `DocumentoPolicy`.
- Protección contra IDOR mediante Route Model Binding y validación en Gate.
- Cobertura total de permisos View / Update / Delete / Evaluate.
- Los documentos son almacenados de forma privada usando el disco `local` y accedidos únicamente mediante Controladores validados.

## 4. Arquitectura Implementada y Proyectada
El proyecto sigue el patrón **MVC extendido**, garantizando *Clean Architecture* y separación de responsabilidades:
- **Modelos siempre en Inglés:** Regla de oro (`CompanyAdvisor`, `Alumno`, etc.).
- **Repository Pattern:** `DocumentoRepository`, `AlumnoRepository`, `NotificacionRepository`.
- **Service Layer:** Lógica de negocio pesada (`DocumentoService`).
- **Enums:** Para estados del sistema (`DocumentoEstado`).
- **Events/Listeners:** Desacoplamiento de lógica reactiva.
- **Policies:** Pendiente de implementación completa.

## 5. Base de Datos
- **Motor:** MySQL 8
- **Modelos Configurados:** `User`, `Alumno`, `Asesor`, `Asignacion`, `Etapa`, `Documento`, `Notificacion`, `CompanyAdvisor`.

## 6. Siguientes Pasos
1. Implementar la asignación gráfica de alumnos a asesores por parte del Coordinador.
2. Añadir retroalimentación explícita (comentarios) al rechazar un formato.
3. Evaluar e iniciar tareas del Backlog v2.

## 7. Notas Técnicas y Decisiones Recientes
- Se agregaron las columnas `carrera` y `cuatrimestre` a `alumnos`.
- Se implementó `CompanyAdvisor` como relación 1 a 1 con el alumno para capturar los datos de la empresa de manera aislada (cumpliendo con principios SOLID).
- Las etapas dejaron de llamarse "Etapa 1" para adoptar la nomenclatura real de UTGZ (FOR-06-12, FOR-06-10, etc.) y se añadió el flag `activo` para control de versiones.
