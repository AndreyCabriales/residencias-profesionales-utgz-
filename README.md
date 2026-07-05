

# Sistema de Residencias Profesionales UTGZ

Plataforma web institucional desarrollada para la **Universidad Tecnológica de Gutiérrez Zamora (UTGZ)**. Este sistema automatiza y digitaliza el seguimiento del proceso de residencias profesionales, eliminando el papeleo físico y centralizando la comunicación entre Alumnos, Asesores y Coordinadores.

## 🚀 Características Principales

- **Gestión Multi-Rol:** Paneles de control independientes y protegidos para Coordinadores, Asesores y Alumnos.
- **Flujo Documental Automatizado:** Subida física de PDFs, validación de formatos (FOR-06-12) y transición automática de etapas mediante arquitectura basada en Eventos.
- **Asignaciones Claras:** Los alumnos están vinculados 1-a-1 con un Asesor Académico y un Asesor Organizacional (Empresa).
- **Dashboard Analítico:** Gráficas en tiempo real (Chart.js) y flujo de actividad para el coordinador.
- **Diseño Aesthetic Institucional:** Desarrollado con TailwindCSS respetando los lineamientos gráficos de la universidad, animaciones sutiles y microinteracciones.

## 🛠️ Stack Tecnológico (Clean Architecture)

- **Backend:** PHP 8.2 + Laravel 11.
- **Arquitectura:** Repositories, Services, Events, Policies.
- **Frontend:** Blade + TailwindCSS + Alpine.js.
- **Base de Datos:** MySQL 8.
- **Gestión de Permisos:** Spatie Laravel-Permission.

*(Para más detalle técnico, consulta `docs/TECH_STACK.md` y `docs/SYSTEM_OVERVIEW.md`).*

## 📚 Documentación Técnica

La documentación extensa del proyecto vive en la carpeta `docs/`. Está pensada para capacitar a cualquier nuevo desarrollador que entre al equipo.

- [Visión General (System Overview)](docs/SYSTEM_OVERVIEW.md)
- [Base de Datos (ERD y Modelos)](docs/DATABASE.md)
- [Roles y Permisos](docs/ROLES_AND_PERMISSIONS.md)
- [Endpoints y API](docs/API.md)
- [Stack Tecnológico](docs/TECH_STACK.md)
- [Guía de Despliegue Local](docs/DEPLOYMENT.md)
- [Historial de Versiones (Changelog)](docs/CHANGELOG.md)
- [Backlog (V2)](docs/BACKLOG.md)
- [Decisiones de Arquitectura (ADRs)](docs/ARCHITECTURE_DECISIONS.md)

## 💻 Instalación Local

### Requisitos
- PHP 8.2+, Composer, Node.js, MySQL.

### Pasos
1. Clona el repositorio: `git clone https://github.com/utgz/residencias-profesionales-utgz.git`
2. Instala dependencias Backend: `composer install`
3. Instala dependencias Frontend: `npm install`
4. Configura tu `.env` (credenciales DB).
5. Genera la key: `php artisan key:generate`
6. Corre las migraciones y llena los datos prueba: `php artisan migrate:fresh --seed`
7. Compila los assets (Terminal 1): `npm run dev`
8. Levanta el servidor (Terminal 2): `php artisan serve`

*(Consulta `docs/DEPLOYMENT.md` para más información).*

## 🔒 Estado del Proyecto
**Sprint 3 Completado.** El sistema se encuentra en fase Beta funcional (Módulo de documentos, asignaciones, subidas y evaluaciones automatizadas). Próximas iteraciones se documentan en `docs/BACKLOG.md`.

## 📜 Licencia
Este software es propiedad de la Universidad Tecnológica de Gutiérrez Zamora (UTGZ) y se distribuye con fines institucionales y académicos.
