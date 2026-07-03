# Estado del Proyecto: Sistema de Registro y Seguimiento de Residencias Profesionales UTGZ

## 1. Objetivo General
Construir una plataforma web escalable, segura y mantenible para digitalizar y automatizar el proceso de registro y seguimiento de residencias profesionales en la Universidad Tecnológica de Gutiérrez Zamora (UTGZ). El sistema debe funcionar como un producto profesional que facilite la comunicación y revisión de documentos entre Coordinadores, Asesores y Alumnos.

## 2. Estado Actual
**Sprint Actual:** Sprint 2 (Módulo de Documentos y Arquitectura Limpia)
**Progreso Global:** ~50%
**Rama Activa:** `feature/modulo-documentos` (Lista para ser fusionada a `develop`)

## 3. Funcionalidades
### Terminadas (Sprint 1 y 2)
- [x] Arquitectura de base de datos y migraciones (Alumnos, Asesores, Asignaciones, Etapas, Documentos, Notificaciones).
- [x] Configuración de Roles y Permisos (Spatie Laravel-Permission).
- [x] Seeders base (Roles, Usuarios de prueba, Etapas del proceso).
- [x] Instalación de Laravel Breeze.
- [x] Rediseño UI Split-Screen para Login interactivo y branding UTGZ.
- [x] Redirección de login condicionada por rol y protección de rutas.
- [x] Layout principal responsivo con Sidebar dinámico y animaciones Fade-In (Tailwind CSS).
- [x] Vistas base (Dashboards) para Coordinador, Asesor y Alumno.
- [x] **Módulo de Documentos:** Subida de archivos, almacenamiento local y validación con Form Requests.
- [x] **Flujo de Revisión:** Listado de documentos, y Aprobación/Rechazo de documentos por el Asesor.
- [x] **Automatización de Etapas:** Implementación de Events & Listeners (`DocumentoRevisado` y `AvanzarEtapaAlumno`) para avance automático.

### Pendientes (Sprints 3-4)
- [ ] **API REST:** Endpoints protegidos con Laravel Sanctum para consumos futuros/móviles.
- [ ] **Servicio de Notificaciones:** Patrón Singleton y envío de correos vía Mailtrap/SMTP ante eventos de cambio de estado.
- [ ] **Seguridad Avanzada:** Policies para autorización fina, Headers CSP.
- [ ] **UX/UI en Tiempo Real:** Cargas asíncronas con Axios/Fetch, estados de carga y feedback visual sin recargar página.
- [ ] **CRUDs de Administración:** Vistas para el Coordinador (Gestión de alumnos y asesores desde interfaz).

## 4. Arquitectura Implementada y Proyectada
El proyecto sigue el patrón **MVC extendido**, garantizando *Clean Architecture* y separación de responsabilidades:
- **Controladores:** Capa delgada que atiende la petición HTTP y retorna respuestas (`AlumnoDocumentoController`, `AsesorDocumentoController`).
- **Service Layer (Implementado):** Lógica de negocio encapsulada (`DocumentoService`).
- **Repository Pattern (Implementado):** Abstracción de acceso a datos (`DocumentoRepository`, `AlumnoRepository`).
- **Events/Listeners (Implementado):** Desacoplamiento de lógica reactiva (`DocumentoRevisado`, `AvanzarEtapaAlumno`).
- **Policies (Por implementar):** Para garantizar que un Asesor solo pueda ver/aprobar documentos de *sus* alumnos.

## 5. Base de Datos
- **Motor:** MySQL 8
- **Modelos Configurados:** `User`, `Alumno`, `Asesor`, `Asignacion`, `Etapa`, `Documento`, `Notificacion`.

## 6. Siguientes Pasos
1. Fusionar `feature/modulo-documentos` hacia `develop`.
2. Crear rama para **Notificaciones y APIs** o **ABCs del Coordinador**.
3. Considerar despliegue en entorno de staging.

## 7. Notas Técnicas y Decisiones Recientes
- Se optó por una estructura de colores definida en `tailwind.config.js` (`utgz-primary`, `utgz-accent`) para mantener consistencia UI.
- La tabla de `etapas` se procesa como un catálogo ordenado (1 a 4) para facilitar el avance sistemático del alumno sin *hardcodear* los nombres en el código fuente.
- Las migraciones fueron ajustadas (orden) para resolver dependencias de *Foreign Keys* (Etapas debe existir antes que Alumnos).
