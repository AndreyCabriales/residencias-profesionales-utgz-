# Roles y Permisos

El sistema utiliza el paquete `spatie/laravel-permission` para gestionar la autorización de manera granular. A diferencia de un sistema rígido donde un rol es un enum, aquí usamos Roles que contienen Permisos, lo que permite escalabilidad.

## ¿Cómo funciona Spatie?
1. Se crean **Permisos** individuales (ej. `aprobar documentos`, `subir documentos`).
2. Se crean **Roles** (ej. `Coordinador`).
3. Se asignan Permisos a los Roles.
4. Se asignan Roles a los Usuarios.

Si mañana la universidad crea un puesto de "Auditor", simplemente creamos el Rol "Auditor" y le damos permisos de lectura, sin tocar el código fuente, solo modificando la base de datos.

---

## 1. Rol: Coordinador
Es el administrador principal del módulo de residencias.

### Permisos Habilitados (Proyectados)
- `ver dashboard coordinador`
- `gestionar alumnos` (CRUD)
- `gestionar asesores` (CRUD)
- `gestionar asignaciones`
- `ver estadisticas`

### Restricciones
- El coordinador no debería subir documentos en nombre del alumno (salvo casos de emergencia administrativa justificada).
- No evalúa documentos directamente (eso recae en el Asesor).

---

## 2. Rol: Asesor
Docente encargado de guiar y aprobar el trabajo del alumno.

### Permisos Habilitados
- `ver dashboard asesor`
- `revisar documentos asignados`
- `aprobar documentos`
- `rechazar documentos`

### Políticas de Seguridad (Policies)
A pesar de tener el permiso `aprobar documentos`, el Asesor solo puede aplicarlo si pasa la barrera de la **Policy**.
La `DocumentoPolicy` verifica: ¿El alumno dueño de este documento, está asignado a este Asesor?
Si la respuesta es no, se lanza una excepción de acceso denegado (HTTP 403 Forbidden).

---

## 3. Rol: Alumno
Usuario final del sistema.

### Permisos Habilitados
- `ver dashboard alumno`
- `subir documentos`
- `ver notificaciones propias`
- `actualizar perfil`

### Restricciones Críticas
- No puede subir un documento si ya tiene uno en estado "Pendiente" de revisión (Bloqueado por validación de negocio en el Servicio).
- No puede eliminar un documento que ya haya sido "Aprobado" (La historia es inmutable).
- No puede acceder a rutas que inicien con `/asesor` o `/coordinador` (Bloqueado por Middleware).

---

## Implementación Técnica (Ejemplo)

En los archivos de rutas (`routes/web.php`):

```php
// Solo los usuarios con Rol "coordinador" pueden entrar aquí
Route::middleware(['auth', 'role:coordinador'])->group(function () {
    Route::get('/coordinador/dashboard', [DashboardController::class, 'coordinador'])->name('coordinador.dashboard');
});
```

En las vistas (Blade):

```html
@role('asesor')
    <li><a href="/asesor/dashboard">Mis Alumnos</a></li>
@endrole
```
