# Stack Tecnológico

El Sistema de Residencias UTGZ se construyó seleccionando herramientas maduras, probadas en la industria y altamente compatibles entre sí para asegurar un mantenimiento a largo plazo.

| Tecnología | ¿Para qué sirve? | ¿Por qué fue elegida y cómo la usamos? |
|------------|------------------|---------------------------------------|
| **PHP 8** | Lenguaje de programación del Backend. | Es el lenguaje de mayor adopción en la web. Usamos características modernas (Enums, Constructor Property Promotion, Type Hinting). |
| **Laravel 12** | Framework Backend MVC. | Estandariza el desarrollo. Usamos su motor ORM (Eloquent), su enrutador, su motor de plantillas (Blade) y su sistema de Eventos. Elegido porque acelera el desarrollo seguro sin reinventar la rueda. |
| **MySQL 8** | Sistema de Gestión de Bases de Datos Relacional. | Maneja la persistencia de datos (Usuarios, Documentos). Se eligió por su estabilidad e integridad referencial (Foreign Keys rígidas). |
| **Tailwind CSS** | Framework Frontend de utilidades (CSS). | Permite diseñar interfaces (Dashboards) escribiendo clases directamente en el HTML (`bg-blue-500 hover:shadow`). Se eligió porque evita archivos CSS gigantes e inantenibles, garantizando consistencia "Aesthetic". |
| **Alpine.js** | Framework Frontend de JavaScript ligero. | Añade interactividad (Modales, botones deshabilitables al hacer clic) sin el peso de React o Vue. Se usa mediante el atributo `x-data`. |
| **Chart.js** | Librería de JavaScript para gráficas. | Se utiliza en el Dashboard del Coordinador para generar la gráfica de "Doughnut" sobre el estado global de los documentos. |
| **Spatie Laravel-Permission** | Paquete de roles y permisos para Laravel. | Administra quién puede hacer qué. Se eligió porque es el estándar de la industria en Laravel. Lo usamos para asignar roles de Alumno, Asesor y Coordinador. |
| **Sanctum (Pendiente)** | Paquete de autenticación para APIs. | Planeado para el Backlog, se usará para emitir Tokens (Bearer) si la universidad decide hacer una App Móvil nativa en Flutter. |
| **Storage (Laravel)** | API de abstracción de archivos. | Guarda los PDFs en discos locales (`storage/app/documentos`). Elegido porque provee seguridad nativa impidiendo el acceso directo por URL pública. |
| **Mail (Laravel)** | API de envío de correos. | Integrado para enviar los enlaces de recuperación de contraseñas. A futuro se enlazará mediante SMTP (Ej. Mailtrap) para alertas del proceso de residencia. |
| **Composer** | Gestor de dependencias de PHP. | Permite instalar Laravel y Spatie con comandos simples. Esencial para mantener el proyecto replicable. |
| **Git / GitHub** | Control de versiones y alojamiento de código. | Permite trabajo colaborativo. Usamos ramas (`develop`, `feature/modulo-documentos`) para organizar el código. |

## Ventajas Generales del Stack
1. **Seguridad Integrada:** Al usar Laravel, los ataques comunes (Inyección SQL, XSS, CSRF) están cubiertos automáticamente por el framework y el motor de plantillas Blade.
2. **Despliegue Económico:** Un servidor Linux (Ubuntu) básico con Apache/Nginx y PHP-FPM es suficiente para alojar la aplicación; no se requieren orquestadores costosos como Kubernetes para arrancar.
3. **Curva de Aprendizaje:** Tailwind y Alpine son extremadamente amigables para nuevos desarrolladores Frontend, y Laravel tiene la documentación más extensa y la comunidad más grande de PHP.
