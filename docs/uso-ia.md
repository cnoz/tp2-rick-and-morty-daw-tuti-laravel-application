# Registro de uso de Inteligencia Artificial

## Trabajo realizado con asistencia de IA

- Lectura y separación de los requisitos de la consigna del TP2 y de las decisiones solicitadas por el equipo.
- Revisión del SQL, el importador, el HTML, los estilos y los recursos gráficos del TP1.
- Preparación de la base de Laravel 13 con estructura MVC.
- Adaptación del modelo del TP1 a migraciones, modelos Eloquent y relaciones.
- Creación del comando reproducible de importación desde la API de Rick and Morty.
- Adaptación del diseño del TP1 a un layout y vistas Blade sin una SPA.
- Preparación de Docker, documentación y pruebas automatizadas.

## Criterios de validación aplicados

- Se contrastó la versión y los requisitos de PHP con la documentación oficial de Laravel.
- Se conservaron los identificadores entregados por la API y las relaciones del TP1.
- Se agregaron pruebas para la página de inicio y la importación con relaciones.
- Se revisaron rutas, migraciones, formato del código y configuración de ejemplo.
- Las 3 pruebas automatizadas finalizaron correctamente con 11 aserciones.
- Se comprobó que la home, el CSS y el logo respondieran correctamente.
- `docker compose build` construyó correctamente la imagen PHP 8.4 de la aplicación.
- Los servicios `app` y `db` iniciaron correctamente; MySQL quedó en estado `healthy`.
- Las migraciones y las 3 pruebas automatizadas finalizaron correctamente dentro del contenedor.
- La página de inicio respondió HTTP 200 desde Docker.
- La carga real se completó con 126 ubicaciones, 51 episodios, 826 personajes y 1267 relaciones.
- Se retiró el listado público de personajes para dejar solamente la home estática solicitada por el equipo.
- No se agregaron credenciales reales ni se publicó el proyecto.

## Revisión pendiente por el equipo

- Cada integrante debe leer y poder explicar los modelos, relaciones, migraciones, comando y vistas.
- Revisar los textos y el diseño visual antes de la entrega final.
- Realizar una revisión visual final en distintos tamaños de pantalla; el navegador visual no estuvo disponible durante esta preparación.
- Completar este registro cuando se utilice IA en las próximas funcionalidades.
