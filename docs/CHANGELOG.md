# Changelog

Este archivo rastrea todos los cambios notables realizados en el proyecto.
El formato se basa en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/), y este proyecto se adhiere a [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v0.3] - 2026-07-03 (Sprint 3)
### Seguridad
- **DocumentoPolicy implementada.** Protección frente a IDOR mediante Route Model Binding y Gate. Previene manipulación de URLs para acceder o evaluar documentos de otros asesores/alumnos. Se corrigió un bug que impedía a los alumnos eliminar sus propios documentos pendientes.

### Añadido
- **Dashboards Definitivos:** Gráfica de Doughnut (Chart.js) y Actividad Reciente para el Coordinador. Grid analítico de 5 tarjetas para el Alumno.
- **Entidad CompanyAdvisor:** Relación 1 a 1 para capturar de forma normalizada los datos de la Empresa, Asesor Organizacional y Puesto. Solo se solicita en la etapa FOR-06-12.
- **Branding & UX:** Traducción total al español del módulo de Perfil (Profile). Implementación de paleta de colores oficial UTGZ, botones con estados interactivos (disabled, hover, focus).
- **Documentación Técnica Extensiva:** Se generaron `SYSTEM_OVERVIEW.md`, `DATABASE.md`, `API.md`, `TECH_STACK.md`, `ROLES_AND_PERMISSIONS.md`, `WORKFLOW.md` y `DEPLOYMENT.md`.

### Cambiado
- **Seeders Realistas:** Se depuró el Seeder para incluir nombres reales de docentes, matrículas institucionales válidas, carreras y cuatrimestres reales de la UTGZ.
- **Catálogo de Etapas:** Las etapas se renombraron con sus códigos oficiales (FOR-06-12, FOR-06-10) abandonando los identificadores genéricos ("Etapa 1"). Se agregó el flag `activo` en la BD para futuro control de versiones de formatos.

## [v0.2] - 2026-07-02 (Sprint 2)
### Añadido
- **Arquitectura Limpia:** Implementación del Patrón Repository (Ej. `DocumentoRepository`) para extraer consultas Eloquent de los Controladores.
- **Service Layer:** `DocumentoService` para abstraer la lógica pesada de subida de archivos físicos, su validación y persistencia segura en disco privado.
- **Lógica Reactiva (Events/Listeners):** Creación del evento `DocumentoRevisado` y su listener `AvanzarEtapaAlumno` para automatizar la transición entre etapas del alumno sin intervención manual del Coordinador.

### Cambiado
- **Refactor de Controladores:** `AlumnoDocumentoController` ahora es extremadamente delgado.

## [v0.1] - 2026-07-01 (Sprint 1)
### Añadido
- **Fundación del Proyecto:** Inicialización de Laravel 11 y configuración de TailwindCSS.
- **Base de Datos Core:** Creación de migraciones principales: `users`, `alumnos`, `asesores`, `asignaciones`, `etapas`, `documentos`.
- **Roles y Permisos:** Instalación y configuración global de `spatie/laravel-permission` (Roles: Coordinador, Asesor, Alumno).
- **Sistema de Autenticación:** Integración de Laravel Breeze y rediseño de la vista Split-Screen para Login con identidad gráfica universitaria.
- **Layouts y Protecciones:** Middleware de redirección por roles post-login. Diseño base con Sidebar dinámico.
