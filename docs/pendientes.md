# Funcionalidades pendientes

Este documento describe el trabajo previsto, pero todavía no implementado. No existen rutas hacia controladores o vistas pendientes.

## Explorador público

- Listado y detalle de personajes.
- Listado y detalle de episodios.
- Listado y detalle de ubicaciones.
- Navegación entre personajes, episodios y ubicaciones relacionadas.

## Autenticación

La migración y el modelo `User` de Laravel se conservan como punto de partida. Falta implementar registro, inicio y cierre de sesión, validaciones y vistas. El explorador debe seguir siendo público.

## Listas personalizadas

Antes de implementar, el equipo debe diseñar las migraciones y autorizaciones respetando estas reglas:

- Cada lista pertenece a un solo usuario.
- Una lista admite exclusivamente personajes o exclusivamente episodios.
- Un personaje o episodio no puede repetirse dentro de la misma lista.
- Un elemento puede aparecer en listas diferentes.
- Solo el propietario puede crear, modificar o eliminar su lista y administrar sus elementos.
- Las restricciones importantes deben respaldarse tanto con validaciones como con índices únicos y claves foráneas.
