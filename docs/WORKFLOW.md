# Flujo de Trabajo del Equipo (Workflow)

El equipo de desarrollo de Residencias UTGZ sigue una metodología ágil apoyada por prácticas estrictas de control de versiones.

## 1. Git Flow Simplificado

Se utilizan ramas para separar los ambientes de desarrollo y asegurar que la rama principal siempre tenga código funcional.

- `main` / `master`: Contiene el código de producción. Nunca se envían *commits* directamente aquí.
- `develop`: Rama de integración. Aquí se fusionan todas las nuevas características antes de pasar a producción.
- `feature/*`: Ramas temporales creadas a partir de `develop` para desarrollar una nueva funcionalidad (ej. `feature/modulo-documentos`).
- `hotfix/*`: Ramas para reparar errores críticos directamente en producción.

### Proceso de Desarrollo
1. Un desarrollador toma una tarea del Backlog.
2. Crea una rama: `git checkout -b feature/login-rediseño`.
3. Desarrolla la funcionalidad, haciendo commits atómicos (pequeños y descriptivos).
4. Sube la rama y crea un **Pull Request (PR)** hacia `develop`.
5. Otro miembro del equipo revisa el PR (Code Review).
6. Si es aprobado, se fusiona (Merge).

## 2. Gestión del Proyecto (Documentación Activa)

Para evitar la desincronización, el estado del proyecto reside dentro del mismo código fuente en la carpeta `docs/`.

- **PROJECT_STATUS.md:** Es nuestra pizarra virtual. Muestra el % de avance, el Sprint actual y las tareas por hacer. Si alguien se incorpora hoy al equipo, leyendo este archivo sabe exactamente dónde estamos.
- **BACKLOG.md:** La "nevera" de ideas. Si a un profesor se le ocurre agregar un "Chat con Inteligencia Artificial", no desviamos el Sprint actual, simplemente anotamos la idea en el Backlog para Sprints futuros.
- **ARCHITECTURE_DECISIONS.md (ADRs):** El registro de por qué tomamos decisiones técnicas. Si en 3 meses alguien se pregunta "¿Por qué la tabla se llama `company_advisors` en inglés y no `asesores_empresariales`?", la respuesta está documentada ahí.
- **CHANGELOG.md:** Archivo que le muestra al usuario final qué se agregó en cada nueva versión.

## 3. Toma de Decisiones Técnicas

El equipo cuenta con los siguientes roles (humanos/IA):
- **Desarrollador (Ingeniero de Software):** Implementa el código, propone ideas y crea los Pull Requests.
- **Arquitecto de Software:** Define la estructura (Clean Architecture, Repositorios) y decide si una nueva tabla debe ser 1 a 1 o 1 a N. Aprueba cambios sustanciales antes de que se programen.
- **Revisor (Senior Backend Reviewer):** Audita el código buscando brechas de seguridad (IDOR), N+1 queries, y violaciones a los principios SOLID.

Ninguna funcionalidad mayor se implementa sin consenso. Si hay discrepancias, se debate la viabilidad a futuro y se documenta como un ADR.
