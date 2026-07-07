# Guía de Defensa del Proyecto (DEFENSE_GUIDE)

Este documento es un "Manual de Defensa". Está diseñado para que cualquier integrante del equipo de desarrollo pueda defender técnicamente el proyecto ante un jurado, profesores o auditores externos. 
Responde a las preguntas más críticas sobre las decisiones arquitectónicas que se tomaron durante la construcción del Sistema de Residencias Profesionales UTGZ.

---

### 1. ¿Por qué eligieron Laravel y no otro framework o lenguaje (Node, Python)?
**Respuesta sugerida:**
"Elegimos Laravel (PHP 8) porque para un sistema institucional monolítico que requiere gestión robusta de sesiones, bases de datos relacionales complejas y control estricto de roles, Laravel es el estándar de la industria. Si hubiéramos usado Node.js (Express), tendríamos que haber 'armado' nuestro propio framework instalando decenas de librerías para ORM, seguridad (CSRF, XSS), envío de correos y subida de archivos, asumiendo riesgos de seguridad. Laravel nos provee todo eso empaquetado, testeado y blindado, permitiéndonos enfocarnos en resolver el problema de la UTGZ en lugar de reinventar la rueda técnica."

### 2. ¿Qué aporta `Spatie Laravel-Permission` que no podrían haber hecho manualmente con un campo `rol` en la tabla usuarios?
"Tener un simple campo `rol = 'coordinador'` es rígido. Spatie nos permite escalar. Si mañana la universidad decide crear el rol de 'Subcoordinador', que puede ver los documentos pero no puede aprobarlos, un campo `rol` nos obligaría a llenar el código de múltiples `if (rol == 'coordinador' || rol == 'subcoordinador')`. Con Spatie, el código solo pregunta `if($user->can('ver documentos'))`. Nosotros solo creamos el rol en la base de datos y le asignamos ese permiso, sin necesidad de tocar ni una sola línea de código fuente."

### 3. ¿Por qué separar la lógica en `Services` y `Repositories` en lugar de hacerlo todo en el Controller?
"Para cumplir con el Principio de Responsabilidad Única (SRP) y facilitar la mantenibilidad. Los Controladores ('Fat Controllers') se vuelven inmanejables si allí mismo validamos la request, subimos el PDF al disco duro, hacemos un `where()` complejo en la base de datos y retornamos la vista. 
En nuestra arquitectura:
- El **Controller** solo recibe la petición.
- El **Service** maneja la lógica de negocio (subir el PDF de forma segura).
- El **Repository** se encarga de hablar con la base de datos.
Si el próximo cuatrimestre la escuela nos pide hacer una App Móvil, podemos reutilizar el `DocumentoService` y el `DocumentoRepository` para la API Móvil, sin tener que duplicar código."

### 4. Noté que los modelos y algunas tablas están en inglés (ej. `CompanyAdvisor`), ¿por qué si es un proyecto para México?
**Respuesta sugerida:**
"Es una convención estándar en el desarrollo de software y una 'Regla de Oro' en Laravel. El framework está diseñado en inglés y cuenta con pluralización automática. Si llamamos a un modelo `AsesorOrganizacional`, Laravel buscará la tabla `asesor_organizacionals`, lo cual nos obligaría a forzar configuraciones manuales constantemente. Mezclamos español en el UI y en algunos modelos heredados (`Alumno`, `Asesor`), pero los modelos complejos nuevos se crearon en inglés para aprovechar el poder nativo del ORM (Eloquent) y las relaciones mágicas sin fricción."

### 5. ¿Qué patrón de diseño se utiliza cuando un documento aprobado cambia automáticamente la etapa del alumno? ¿Por qué no poner ese código justo después de aprobarlo?
**Respuesta sugerida:**
"Utilizamos el patrón de diseño Observador (Observer / Pub-Sub) mediante el sistema de **Eventos y Listeners** de Laravel. Si en el `AsesorDocumentoController` ponemos el código para avanzar de etapa, y mañana nos piden que además se envíe un correo y un SMS, el controlador terminaría teniendo 100 líneas de código y tardaría segundos en responder.
Al usar eventos, el controlador simplemente 'grita' al sistema: *'¡Documento Aprobado!'* (`event(new DocumentoRevisado)`), y responde inmediatamente al usuario. En segundo plano, un *Listener* (`AvanzarEtapaAlumno`) escucha ese grito y hace el cálculo de la etapa de forma aislada. Esto desacopla el código completamente."

### 6. ¿Qué riesgos de seguridad mitigaron con `Policies`?
**Respuesta sugerida:**
"Mitigamos el riesgo de **IDOR** (Insecure Direct Object Reference). Si un Asesor malintencionado intenta entrar a la URL `/asesor/documento/55/evaluar` (un documento que pertenece a un alumno de otro maestro), el Middleware de Spatie lo dejaría pasar porque sí tiene el rol de Asesor. Sin embargo, la `DocumentoPolicy` intercepta la petición, verifica en la tabla `asignaciones` si ese alumno le pertenece a él, y como no es así, le arroja un error `403 Forbidden`. Protegemos los datos a nivel de fila (Row-Level Security)."

### 7. ¿Por qué decidieron sacar los datos de la Empresa a una tabla 1 a 1 (`company_advisors`) en lugar de poner todo en la tabla de `alumnos`?
**Respuesta sugerida:**
"Por el principio de Normalización. La tabla `alumnos` debe guardar solo los datos académicos del estudiante (Matrícula, Carrera). Si le hubiéramos puesto `empresa_nombre`, `empresa_telefono`, estaríamos contaminando la entidad. Extraerlo a `company_advisors` no solo limpia la base de datos, sino que nos prepara para el futuro: si el próximo año nos piden que el Asesor de la Empresa pueda iniciar sesión en el sistema, ya tenemos una entidad separada que podemos escalar fácilmente."

### 8. En cuanto al Frontend, ¿por qué Tailwind CSS y Alpine.js en lugar de Bootstrap o React?
**Respuesta sugerida:**
"Bootstrap tiende a hacer que todos los sitios luzcan genéricos e idénticos, y suele requerir sobrescribir mucho CSS. TailwindCSS nos permitió construir una UI 100% personalizada (Aesthetic) alineada a los colores de la UTGZ sin salir del HTML. Por otro lado, React o Vue.js hubieran añadido una complejidad innecesaria (creación de APIs, manejo de estados, compilación pesada) para un sistema que es primordialmente un CRUD transaccional. Alpine.js nos dio la reactividad exacta que necesitábamos (ej. botones 'disabled' al cargar, modales) con una fracción del peso y esfuerzo."

---
*Este documento fue generado como parte integral de la documentación del proyecto, buscando elevar el estándar de calidad y profesionalismo del equipo.*
