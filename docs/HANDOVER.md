# Handover Document: Sistema de Registro y Seguimiento de Residencias Profesionales UTGZ

**Última Actualización:** Julio 2026
**Rama Activa:** `feature/modulo-documentos` (Actualmente tiene todos los avances de la Fase 3 y Fase 4, lista para ser fusionada a `develop`).

## 1. Contexto General del Proyecto
Este es un proyecto universitario para la **Universidad Tecnológica de Gutiérrez Zamora (UTGZ)**. 
El objetivo es construir una plataforma web para automatizar el registro y seguimiento de residencias profesionales. 
Se está desarrollando con un enfoque **altamente profesional y Clean Architecture**. No es un simple script de fin de semana, se está construyendo para ser mantenible y escalable.

**Stack Tecnológico:**
- Laravel 12 (PHP 8.2+)
- MySQL 8
- Blade + Alpine.js + Tailwind CSS
- Laravel Breeze (Autenticación)
- Spatie Laravel-Permission (Roles y Permisos)

## 2. Lo que YA ESTÁ IMPLEMENTADO (Fase 1 a 4)

### Arquitectura de Base de Datos y Seguridad
- **Migraciones completas:** Tablas para `alumnos`, `asesores`, `asignaciones`, `etapas`, `documentos` y `notificaciones`.
- **Roles configurados:** `coordinador`, `asesor` y `alumno`.
- **Autenticación inteligente:** Laravel Breeze modificado. Cuando alguien hace login, el sistema detecta su rol y lo redirige a su Dashboard específico (Coordinador, Asesor o Alumno).
- **Protección de Rutas:** Todas las rutas están protegidas por middlewares de auth y role.

### Interfaz de Usuario (UI/UX)
- Se implementó un diseño moderno, responsivo y con **colores institucionales (UTGZ)** definidos en `tailwind.config.js`.
- Se rediseñó el `welcome.blade.php` (Landing Page) y `login.blade.php` (Guest layout) con pantalla dividida (Split-Screen) y micro-animaciones (Fade-In-Up).
- Dashboards diferenciados e interactivos para los 3 roles.

### Módulo de Documentos (Clean Architecture)
- **Repositorios y Servicios:** Toda la interacción con la base de datos se abstrajo mediante el patrón Repositorio (`AlumnoRepository`, `DocumentoRepository`). La lógica de subir archivos se maneja a través de un `DocumentoService`.
- **Enums:** Se crearon `DocumentoEstado` y `RolUsuario` respaldados (Backed Enums).
- **Flujo Alumno:** Puede subir un PDF (máximo 5MB). Al subirse, queda en estado "Pendiente". Se muestra su historial de documentos.
- **Flujo Asesor:** Tiene una tabla dinámica donde ve los documentos pendientes de sus alumnos. Puede descargar el PDF, "Aprobarlo" o "Rechazarlo" (con motivo).
- **Automatización (Events/Listeners):** Cuando el Asesor aprueba un documento, se dispara un Evento (`DocumentoRevisado`). Un Listener (`AvanzarEtapaAlumno`) escucha este evento y avanza automáticamente la `etapa_id` del alumno en +1.

### Gestión de Usuarios (ABCs del Coordinador)
- **Vistas y Controladores:** El Coordinador tiene su CRUD para registrar `Alumnos` y `Asesores`.
- **Transacciones de BD:** Usamos `DB::transaction` en el `UsuarioService` para crear el registro en la tabla `users`, asignar el Rol de Spatie y crear el registro en `alumnos`/`asesores` al mismo tiempo.
- **Asignaciones:** Al crear un alumno, el Coordinador puede asignarle su Asesor inmediatamente.
- **Contraseñas:** Los nuevos usuarios se crean por defecto con la contraseña `password`.

---

## 3. LO QUE FALTA POR HACER (Siguientes Pasos)

Si estás leyendo esto en una nueva sesión, el usuario te acaba de pedir que retomes el desarrollo. Estas son las tareas pendientes prioritarias (Fase 5):

### Prioridad 1: Seguridad Fina (Policies)
Actualmente, los endpoints de descarga y revisión de documentos (`AsesorDocumentoController`) verifican si el documento existe, pero no verifican si el documento **le pertenece a un alumno asignado a ese asesor en particular**.
- **Tarea:** Crear un `DocumentoPolicy` y aplicarlo a los controladores para evitar IDORs (Insecure Direct Object References). Un asesor solo debe poder interactuar con los PDFs de sus alumnos.

### Prioridad 2: Notificaciones y Correos Electrónicos
El sistema debe ser comunicativo.
- **Tarea:** Configurar el envío de emails y notificaciones internas (tabla `notificaciones`). 
- Ejemplos de triggers: 
  - Al alumno: "Tu asesor ha aprobado tu documento y avanzas a la Fase 2".
  - Al asesor: "El alumno X ha subido un nuevo documento para tu revisión".

### Prioridad 3: Refinamiento de la UX
- Implementar validaciones en tiempo real y alertas más visuales utilizando Alpine.js.
- Evitar que un alumno pueda subir más documentos si ya tiene uno en estado "Pendiente" o "Aprobado" para su etapa actual.

## 4. Estilo de Comunicación (Para la IA)
- Mantén un tono profesional, claro y empático.
- Continúa usando la metodología **Clean Architecture** (Servicios, Repositorios, Observers/Events).
- **No generes código espagueti en los controladores.**
- Mantén actualizado el archivo `docs/PROJECT_STATUS.md` conforme avances.

¡Buena suerte en la continuación del desarrollo!
