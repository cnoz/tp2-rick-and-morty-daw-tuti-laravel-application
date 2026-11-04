# Funcionalidades pendientes

Este documento describe el trabajo previsto, pero todavía no implementado. No existen rutas hacia controladores o vistas pendientes.

## Explorador público

### Personajes

- Listado público paginado y detalle de cada personaje.
- Navegación hacia sus episodios, origen y ubicación actual.
- Incorporación y eliminación de personajes en listas personalizadas.

### Episodios

- Listado público paginado y detalle de cada episodio.
- Navegación hacia sus personajes relacionados.
- Incorporación y eliminación de episodios en listas personalizadas.

### Ubicaciones

- Listado público paginado y detalle de cada ubicación.
- Navegación hacia los personajes relacionados.
- Integración de las ubicaciones con la navegación general.

## Autenticación

La migración y el modelo `User` de Laravel se conservan como punto de partida.

- Registro, inicio y cierre de sesión.
- Validaciones y vistas Blade para los formularios.
- Protección de las funcionalidades privadas para usuarios autenticados.

El explorador debe seguir siendo público.

## Listas personalizadas

Antes de implementar, el equipo debe diseñar las migraciones y autorizaciones respetando estas reglas:

- Cada lista pertenece a un solo usuario.
- Una lista admite exclusivamente personajes o exclusivamente episodios.
- Un personaje o episodio no puede repetirse dentro de la misma lista.
- Un elemento puede aparecer en listas diferentes.
- Solo el propietario puede crear, modificar o eliminar su lista y administrar sus elementos.
- Las restricciones importantes deben respaldarse tanto con validaciones como con índices únicos y claves foráneas.
