# Decisiones de Arquitectura (ADR)

Este documento registra las decisiones arquitectónicas importantes tomadas durante el desarrollo del sistema de Residencias Profesionales UTGZ.

## ADR-001: Modelos en Inglés (Regla de Oro)

**Fecha:** Julio 2026
**Contexto:** El framework (Laravel) asume de forma nativa que los nombres de las tablas y los modelos están en inglés, aplicando pluralización automática (ej. `CompanyAdvisor` -> `company_advisors`).
**Decisión:** Todos los nombres de Modelos Elocuent y nombres de tablas en base de datos deben estar en inglés, o seguir estrictamente la convención de pluralización de Laravel. Se decidió aplicar un enfoque mixto justificado: Los modelos principales (`Alumno`, `Asesor`, `Documento`) ya existían y fueron forzados a español en las tablas, pero cualquier modelo nuevo y complejo como `CompanyAdvisor` se debe crear en inglés.
**Consecuencias:**
- Simplifica el uso de relaciones mágicas de Eloquent.
- Requiere que los desarrolladores hispanohablantes adapten el dominio al inglés en la base de código.

## ADR-002: Patrón Repository y Services (Clean Architecture)

**Fecha:** Julio 2026
**Contexto:** Los Controladores de Laravel tienden a engordar (Fat Controllers) cuando se maneja lógica de subida de archivos, validaciones complejas de negocio (ej. evitar dobles subidas) y consultas complejas a BD.
**Decisión:** Se implementa una versión pragmática del Patrón Repository (`app/Repositories`) para abstraer las consultas a base de datos (ej. `DocumentoRepository`) y una Capa de Servicios (`app/Services`) para la lógica de negocio pura (ej. `DocumentoService` para procesar la subida física del archivo).
**Consecuencias:**
- Controladores delgados que solo manejan Request/Response.
- Facilidad para hacer Unit Testing aislando la base de datos (Mocking del repositorio).

## ADR-003: Relación 1 a 1 para CompanyAdvisor

**Fecha:** Julio 2026
**Contexto:** Se requerían capturar los datos de la Empresa, el Nombre del Asesor Organizacional y su Puesto. Inicialmente se pensó en agregar esas columnas directamente a la tabla `alumnos`.
**Decisión:** Se separó esta información en un modelo y tabla independiente (`CompanyAdvisor`) vinculada mediante una relación 1 a 1 con `Alumno` (`alumno_id`).
**Consecuencias:**
- Respeta el principio de Responsabilidad Única (SRP). La tabla `alumnos` no se contamina con información de terceros.
- Permite en el futuro (Backlog) escalar `CompanyAdvisor` a un modelo de usuario completo para que el asesor organizacional pueda iniciar sesión.

## ADR-004: Eventos y Listeners para Avance Automático

**Fecha:** Julio 2026
**Contexto:** Cuando un Asesor aprueba un documento, el sistema debe revisar si el Alumno completó todos los requisitos para pasar a la siguiente etapa de la Residencia (ej. de FOR-06-12 a FOR-06-10).
**Decisión:** Se usa el sistema de Eventos de Laravel (`DocumentoRevisado`). Un Listener (`AvanzarEtapaAlumno`) se suscribe a este evento y ejecuta la lógica para determinar si el alumno avanza de etapa y registra la Notificación pertinente.
**Consecuencias:**
- Desacoplamiento total. El `AsesorDocumentoController` no sabe nada de etapas ni notificaciones. Simplemente aprueba un documento y dispara el evento.

## ADR-005: Interfaz de Usuario y Branding "Aesthetic"

**Fecha:** Julio 2026
**Contexto:** Los sistemas institucionales universitarios suelen ser percibidos como anticuados, grises y poco responsivos.
**Decisión:** Usar TailwindCSS con clases utilitarias enfocadas en microinteracciones: sombras difuminadas (`shadow-sm`, `hover:shadow-md`), bordes sutiles, micro-elevaciones (`hover:-translate-y-1`), transiciones (`transition-all duration-200`) y colores institucionales (`utgz-primary`, `utgz-accent`). Todo en layouts Split-Screen o Grids organizados.
**Consecuencias:**
- Interfaz muy moderna ("wow effect") que incentiva el uso de la plataforma.
- El código HTML/Blade puede volverse verboso por la cantidad de clases, requiriendo extraer patrones a componentes (`<x-card>`) en un futuro.
