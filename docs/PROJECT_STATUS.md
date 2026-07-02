# Estado del Proyecto: Sistema de Registro y Seguimiento de Residencias Profesionales UTGZ

## 1. Objetivo General
Construir una plataforma web escalable, segura y mantenible para digitalizar y automatizar el proceso de registro y seguimiento de residencias profesionales en la Universidad Tecnológica de Gutiérrez Zamora (UTGZ). El sistema debe funcionar como un producto profesional que facilite la comunicación y revisión de documentos entre Coordinadores, Asesores y Alumnos.

## 2. Estado Actual
**Sprint Actual:** Sprint 1 (Configuración Base, Autenticación y Perfiles)
**Progreso Global:** ~25%
**Rama Activa:** `feature/auth-roles` (Lista para ser fusionada a `develop`)

## 3. Funcionalidades
### Terminadas (Sprint 1)
- [x] Arquitectura de base de datos y migraciones (Alumnos, Asesores, Asignaciones, Etapas, Documentos, Notificaciones).
- [x] Configuración de Roles y Permisos (Spatie Laravel-Permission).
- [x] Seeders base (Roles, Usuarios de prueba, Etapas del proceso).
- [x] Instalación de Laravel Breeze.
- [x] Redirección de login condicionada por rol.
- [x] Protección de rutas mediante Middlewares.
- [x] Layout principal responsivo con Sidebar dinámico (Tailwind CSS).
- [x] Vistas base (Dashboards) para Coordinador, Asesor y Alumno.

### Pendientes (Sprints 2-4)
- [ ] **Módulo de Documentos:** Subida de archivos, almacenamiento local/nube, validación (Form Requests).
- [ ] **Flujo de Revisión:** Aprobación/Rechazo de documentos por parte del Asesor con retroalimentación.
- [ ] **Automatización de Etapas:** Implementación del patrón Observer para avance automático de etapas.
- [ ] **API REST:** Endpoints protegidos con Laravel Sanctum para consumos futuros/móviles.
- [ ] **Servicio de Notificaciones:** Patrón Singleton y envío de correos vía Mailtrap/SMTP ante eventos de cambio de estado.
- [ ] **Seguridad Avanzada:** Policies para autorización fina, Headers CSP.
- [ ] **UX/UI en Tiempo Real:** Cargas asíncronas con Axios/Fetch, estados de carga y feedback visual sin recargar página.

## 4. Arquitectura Implementada y Proyectada
El proyecto sigue el patrón **MVC extendido**, garantizando *Clean Architecture* y separación de responsabilidades:
- **Controladores:** Capa delgada que atiende la petición HTTP y retorna respuestas.
- **Service Layer (Por implementar):** Lógica de negocio (ej. `DocumentoService`).
- **Repository Pattern (Por implementar):** Abstracción de acceso a datos (ej. `DocumentoRepository`, `AlumnoRepository`).
- **Observers (Por implementar):** Disparadores de eventos (ej. `DocumentoObserver` para cambiar la etapa).
- **Policies (Por implementar):** Para garantizar que un Asesor solo pueda ver/aprobar documentos de *sus* alumnos.

## 5. Base de Datos
- **Motor:** MySQL 8
- **Modelos Configurados:** `User`, `Alumno`, `Asesor`, `Asignacion`, `Etapa`, `Documento`, `Notificacion`.

## 6. Siguientes Pasos
1. Fusionar `feature/auth-roles` hacia `develop`.
2. Crear la rama `feature/modulo-documentos`.
3. Diseñar la capa de Servicios y Repositorios antes de exponer la subida de archivos al controlador.
4. Implementar *Enums* para manejar los estados de los documentos (`pendiente`, `en_revision`, `aprobado`, `rechazado`).

## 7. Notas Técnicas y Decisiones Recientes
- Se optó por una estructura de colores definida en `tailwind.config.js` (`utgz-primary`, `utgz-accent`) para mantener consistencia UI.
- La tabla de `etapas` se procesa como un catálogo ordenado (1 a 4) para facilitar el avance sistemático del alumno sin *hardcodear* los nombres en el código fuente.
- Las migraciones fueron ajustadas (orden) para resolver dependencias de *Foreign Keys* (Etapas debe existir antes que Alumnos).
