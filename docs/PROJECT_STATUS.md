# Estado del Proyecto: Sistema de Registro y Seguimiento de Residencias Profesionales UTGZ

## 1. Objetivo General
Construir una plataforma web escalable, segura y mantenible para digitalizar y automatizar el proceso de registro y seguimiento de residencias profesionales en la Universidad Tecnológica de Gutiérrez Zamora (UTGZ). El sistema debe funcionar como un producto profesional que facilite la comunicación y revisión de documentos entre Coordinadores, Asesores y Alumnos.

## 2. Estado Actual
**Sprint Actual:** Sprint 3 (Perfeccionamiento UI/UX, Dashboards y Datos Realistas)
**Progreso Global:** ~70%
**Rama Activa:** `feature/modulo-documentos` (Integrado)

## 3. Funcionalidades
### Terminadas (Sprint 1, 2 y 3)
- [x] Arquitectura de base de datos y migraciones (Alumnos, Asesores, Asignaciones, Etapas, Documentos, Notificaciones, CompanyAdvisors).
- [x] Configuración de Roles y Permisos (Spatie Laravel-Permission).
- [x] Seeders realistas (Asesores reales de UTGZ, etapas oficiales FOR-06-12).
- [x] Instalación de Laravel Breeze y rediseño UI Split-Screen para Login interactivo.
- [x] Layout principal responsivo con Sidebar dinámico y animaciones.
- [x] Dashboard Coordinador: Gráficas (Chart.js), Estadísticas en tiempo real y Actividad reciente.
- [x] Dashboard Alumno: Grid de tarjetas informativas (Estado, Asesores, Empresa, Actualización).
- [x] Dashboard Asesor: Gestión de documentos pendientes.
- [x] **Módulo de Documentos:** Subida de archivos, almacenamiento local y validación.
- [x] **Captura de Empresa:** Solicitud de datos de empresa y Asesor Organizacional (`CompanyAdvisor`) si la etapa es FOR-06-12.
- [x] **Automatización de Etapas:** Implementación de Events & Listeners (`DocumentoRevisado` y `AvanzarEtapaAlumno`).
- [x] **Arquitectura Limpia:** Repositorios (`Alumno`, `Documento`, `Notificacion`), Servicios, Policies.
- [x] Traducción completa y branding en configuración de Perfil de Usuario.
- [x] **Políticas y Seguridad (Policies):** Proteger la visualización y edición de documentos/usuarios para que nadie vea datos que no le corresponden.

### Pendientes (Sprints 4-5)
- [ ] **CRUDs de Administración:** Vistas y controladores para que el Coordinador asigne alumnos a asesores de manera gráfica.
- [ ] **Módulo de Observaciones:** Permitir que los asesores dejen comentarios específicos cuando rechacen un documento.
- [ ] **Notificaciones por Correo:** Enviar alertas (SMTP) cuando un documento se apruebe o rechace.
- [ ] **Firma y Reportes PDF:** Generación de formatos pre-llenados en PDF (Exportación).

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
