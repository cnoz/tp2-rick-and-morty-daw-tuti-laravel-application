# Rick and Morty Explorer - TP02

Base de una aplicación web para el Trabajo Práctico Obligatorio Nº 2 de Desarrollo de Aplicaciones Web. Está desarrollada con Laravel 13, Blade, MySQL y Docker.

El alcance actual es intencionalmente pequeño: la aplicación visible contiene únicamente una página de inicio estática. El modelo de datos, las migraciones y el importador quedan preparados para que el equipo desarrolle las funcionalidades en etapas posteriores.

## Qué hay que instalar

Solo se necesitan Git y Docker. No hay que instalar PHP, Composer, MySQL, Apache, Node ni npm en la computadora: el entorno Docker ya contiene todo lo necesario.

### Windows y macOS

1. Instalar [Git](https://git-scm.com/downloads).
2. Instalar [Docker Desktop](https://www.docker.com/products/docker-desktop/).
3. Abrir Docker Desktop y esperar hasta que indique que el motor está funcionando.

En Windows se recomienda ejecutar los comandos desde PowerShell o Git Bash. Docker Desktop puede solicitar habilitar WSL 2 durante la instalación; en ese caso se deben seguir los pasos indicados por el instalador y reiniciar la computadora.

### Linux

1. Instalar Git con el gestor de paquetes de la distribución.
2. Instalar [Docker Engine](https://docs.docker.com/engine/install/) y el [plugin Docker Compose](https://docs.docker.com/compose/install/linux/).
3. Iniciar el servicio de Docker siguiendo la documentación de la distribución.

### Comprobar las herramientas

Abrir una terminal y ejecutar:

```bash
git --version
docker --version
docker compose version
docker info
```

Los cuatro comandos deben finalizar sin errores. Si `docker info` falla, normalmente significa que Docker Desktop todavía no está abierto o que el servicio de Docker no está iniciado.

También se necesita conexión a Internet durante el primer build y durante la importación de datos.

## Descargar el proyecto

Clonar el repositorio y entrar en su carpeta:

```bash
git clone https://github.com/nataliabogarin/tp2-rick-and-morty-daw-tuti-laravel-application.git
cd tp2-rick-and-morty-daw-tuti-laravel-application
```

Si el proyecto se recibió como ZIP, hay que descomprimirlo, abrir una terminal y ubicarse dentro de la carpeta que contiene `compose.yaml`.

## Primera instalación en local

### 1. Crear el archivo de configuración

En macOS, Linux o Git Bash:

```bash
cp .env.example .env
```

En PowerShell:

```powershell
Copy-Item .env.example .env
```

El `.env` contiene valores locales de ejemplo. No debe subirse a Git ni utilizar credenciales reales de producción.

### 2. Construir las imágenes

```bash
docker compose build
```

La primera construcción descarga las imágenes de PHP y Composer, instala las extensiones necesarias y descarga exactamente las dependencias registradas en `composer.lock`. Puede demorar varios minutos.

### 3. Iniciar la aplicación y MySQL

```bash
docker compose up -d
```

Comprobar que ambos servicios estén iniciados y que MySQL figure como `healthy`:

```bash
docker compose ps
```

### 4. Generar la clave de Laravel

```bash
docker compose exec app php artisan key:generate
```

Este comando modifica únicamente el valor `APP_KEY` del `.env` local.

### 5. Crear las tablas

```bash
docker compose exec app php artisan migrate
```

El comando ejecuta las migraciones pendientes. En la primera instalación crea todas las tablas.

### 6. Preparar los datos del TP1 (opcional en esta etapa)

```bash
docker compose exec app php artisan rick-morty:import
```

La home estática funciona sin ejecutar este paso. El importador consulta todas las páginas de la API pública, conserva sus identificadores y carga ubicaciones, episodios, personajes y relaciones para que el equipo pueda desarrollar las próximas funcionalidades. Puede tardar unos minutos y se puede volver a ejecutar sin duplicar registros.

### 7. Abrir la aplicación

Visitar [http://localhost:8000](http://localhost:8000).

Actualmente no existen otras rutas públicas ni enlaces hacia funcionalidades pendientes.

## Uso diario

Para iniciar un proyecto ya instalado:

```bash
docker compose up -d
```

Para consultar el estado:

```bash
docker compose ps
```

Para ver los registros de Laravel:

```bash
docker compose logs -f app
```

Para ver los registros de MySQL:

```bash
docker compose logs -f db
```

Para detener los contenedores sin perder la base de datos:

```bash
docker compose down
```

Los datos se conservan en un volumen de Docker y vuelven a estar disponibles con el próximo `docker compose up -d`.

## Actualizar una copia existente

Después de descargar cambios del repositorio:

```bash
git pull
docker compose build
docker compose up -d
docker compose exec app composer install --no-interaction
docker compose exec app php artisan migrate
```

No se debe ejecutar `composer update` para una instalación normal, porque podría elegir versiones distintas a las compartidas por el equipo. `composer install` respeta `composer.lock`.

## Configuración

El archivo `.env.example` contiene valores de ejemplo para desarrollo local. Cada integrante debe copiarlo como `.env`; este último está ignorado por Git y no debe contener credenciales reales de producción.

Puertos predeterminados:

- Aplicación: `8000`.
- MySQL en la computadora anfitriona: `3307`.
- MySQL entre contenedores: `3306`.

Si un puerto está ocupado, se puede cambiar `APP_PORT` o `DB_FORWARD_PORT` en `.env` antes de iniciar los contenedores.

La aplicación usa estos servicios:

- `app`: Laravel con PHP 8.4 y Composer.
- `db`: MySQL 8.4.
- Volumen `mysql_data`: conserva la base de datos aunque se detengan los contenedores.
- Volumen `vendor`: conserva las dependencias PHP del contenedor.

## Problemas frecuentes

### Docker no está disponible

Si aparece `Cannot connect to the Docker daemon`, `permission denied` o un mensaje similar, iniciar Docker Desktop y volver a ejecutar `docker info`.

### El puerto 8000 o 3307 está ocupado

Cambiar los valores en `.env`, por ejemplo:

```dotenv
APP_PORT=8080
DB_FORWARD_PORT=3308
```

Después reiniciar los servicios:

```bash
docker compose down
docker compose up -d
```

### Falta la clave de Laravel

Si aparece `No application encryption key has been specified`:

```bash
docker compose exec app php artisan key:generate
```

### MySQL todavía no está listo

Revisar el estado y los logs:

```bash
docker compose ps
docker compose logs db
```

Cuando `db` figure como `healthy`, repetir la migración.

### Los cambios de dependencias no aparecen

```bash
docker compose exec app composer install --no-interaction
docker compose restart app
```

### Reiniciar completamente el entorno local

El siguiente procedimiento elimina la base de datos local y vuelve a crearla:

```bash
docker compose down -v
docker compose build
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan rick-morty:import
```

`docker compose down -v` es destructivo: elimina el volumen de MySQL y todos sus datos locales.

## Base de datos y datos del TP1

El SQL original del TP1 se conserva en `database/tp1/rick_and_morty.sql` como referencia. Para Laravel, su estructura se adaptó a nombres convencionales en minúscula:

| TP1 | Laravel | Contenido |
| --- | --- | --- |
| `LOCATION` | `locations` | Ubicaciones |
| `CHARACTERS` | `characters` | Personajes |
| `EPISODE` | `episodes` | Episodios |
| `CHARACTERS_EPISODE` | `character_episode` | Relación muchos a muchos |

Los valores de los identificadores de la API se conservan. También se mantienen las dos relaciones de ubicación de cada personaje y la relación muchos a muchos entre personajes y episodios.

Para importar o actualizar los datos sin crear duplicados:

```bash
docker compose exec app php artisan rick-morty:import
```

## Comandos que modifican o eliminan datos

Los siguientes comandos deben ejecutarse con cuidado:

- `php artisan migrate`: crea o modifica tablas pendientes. No elimina los datos existentes en el uso normal.
- `php artisan rick-morty:import`: crea registros nuevos y actualiza los existentes con los mismos IDs; también sincroniza las relaciones personaje-episodio.
- `php artisan rick-morty:import --fresh`: **elimina primero todos los personajes, episodios, ubicaciones y relaciones** y después vuelve a importarlos.
- `php artisan migrate:fresh`: **elimina todas las tablas y todos sus datos** antes de ejecutar nuevamente las migraciones.
- `docker compose down -v`: **elimina los contenedores y el volumen de MySQL**, por lo que se pierde la base de datos local.

No hace falta ejecutar comandos destructivos para una instalación normal.

## Pruebas y formato

Ejecutar todas las pruebas automatizadas:

```bash
docker compose exec app php artisan test
```

Aplicar el formato de Laravel Pint:

```bash
docker compose exec app ./vendor/bin/pint
```

## Archivos principales

- `app/Models/`: contiene los modelos y relaciones Eloquent de personajes, episodios y ubicaciones.
- `app/Console/Commands/ImportRickAndMorty.php`: importa los datos desde la API manteniendo IDs y relaciones.
- `database/migrations/`: crea las tablas de Laravel y las adaptadas desde el TP1.
- `resources/views/layouts/app.blade.php`: estructura HTML común de la página.
- `resources/views/home.blade.php`: única página pública, con contenido estático.
- `public/css/app.css`: estilos adaptados del TP1, sin framework de frontend.
- `public/images/`: imágenes reutilizadas del TP1.
- `routes/web.php`: contiene únicamente la ruta de la home.
- `Dockerfile` y `compose.yaml`: entorno reproducible con PHP 8.4 y MySQL 8.4.
- `docs/pendientes.md`: reglas y funcionalidades que todavía debe desarrollar el equipo.
- `docs/uso-ia.md`: registro inicial de la asistencia de IA y las verificaciones realizadas.

## Alcance pendiente y reparto sugerido

1. **Integrante 1 - Personajes:** detalle de personaje y navegación a sus episodios y ubicaciones.
2. **Integrante 2 - Episodios:** listado paginado, detalle y personajes relacionados.
3. **Integrante 3 - Ubicaciones:** listado paginado, detalle y personajes de origen o presentes.
4. **Integrante 4 - Usuarios y listas:** autenticación y listas personalizadas con autorizaciones, coordinando con el resto del equipo las pruebas de integración.

Todos deberían revisar migraciones, navegación, documentación y pruebas antes de unir las ramas. Las reglas obligatorias para las listas están detalladas en `docs/pendientes.md`.
