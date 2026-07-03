# Guía de Despliegue e Instalación Local

Esta guía describe los pasos para levantar el proyecto desde cero en un entorno local (Windows/Mac/Linux) utilizando XAMPP, Laragon, o Laravel Herd.

## Requisitos Previos
- **PHP 8.2** o superior.
- **Composer** v2.
- **Node.js** (v18+) y NPM.
- **MySQL 8** (o MariaDB equivalente).
- **Git**.

## Instalación Paso a Paso

### 1. Clonar el repositorio
Abre tu terminal en la carpeta pública de tu servidor (ej. `htdocs` en XAMPP) y ejecuta:
```bash
git clone https://github.com/utgz/residencias-profesionales-utgz.git
cd residencias-profesionales-utgz
```

### 2. Instalar dependencias de PHP
Composer instalará Laravel y todos los paquetes requeridos (ej. Spatie, Breeze).
```bash
composer install
```

### 3. Instalar dependencias de Frontend (NPM)
NPM instalará TailwindCSS, AlpineJS y herramientas para compilar los assets.
```bash
npm install
```

### 4. Configurar Variables de Entorno
Duplica el archivo de ejemplo para crear tu configuración local.
```bash
cp .env.example .env
```
Abre el archivo `.env` en tu editor de código y ajusta las credenciales de la base de datos:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=residencias_utgz
DB_USERNAME=root
DB_PASSWORD=
```
*Asegúrate de que la base de datos `residencias_utgz` exista en tu gestor (phpMyAdmin, TablePlus).*

### 5. Generar Clave de Aplicación
```bash
php artisan key:generate
```

### 6. Ejecutar Migraciones y Seeders (¡Importante!)
Este comando creará todas las tablas en la base de datos y las llenará con los roles, etapas y usuarios iniciales que necesitamos para probar el sistema.
```bash
php artisan migrate:fresh --seed
```

### 7. Compilar Assets y Levantar Servidor
Debes tener dos pestañas de terminal abiertas.

**Terminal 1 (Compila el CSS/JS en tiempo real):**
```bash
npm run dev
```

**Terminal 2 (Levanta el servidor PHP):**
```bash
php artisan serve
```

*Alternativa XAMPP:* Si usas XAMPP, no necesitas `php artisan serve`, simplemente navega en tu navegador a:
`http://localhost/residencias-profesionales-utgz/public`
*(Asegúrate de configurar tu `APP_URL` en el `.env` acordemente).*

## 8. Cuentas de Prueba (Generadas por el Seeder)
Usa estas credenciales para probar los distintos roles:

- **Coordinador:**
  - Correo: `coordinador@utgz.edu.mx`
  - Contraseña: `password`
- **Asesor (Ejemplo):**
  - Correo: `clopez@utgz.mx`
  - Contraseña: `password`
- **Alumno (Ejemplo):**
  - Correo: `23610062@utgz.edu.mx`
  - Contraseña: `password`
