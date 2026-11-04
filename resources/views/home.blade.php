@extends('layouts.app')

@section('title', 'Inicio - Rick and Morty Explorer')

@section('content')
    <section class="portada">
        <div class="portada-contenido">
            <p class="etiqueta-superior">Explorador interdimensional</p>
            <h1>Personajes, episodios y ubicaciones en un solo lugar</h1>
            <p>
                Esta es la página de inicio del trabajo práctico. Las funcionalidades del
                explorador serán desarrolladas por el equipo en las próximas etapas.
            </p>
        </div>
    </section>

    <section class="estado-proyecto" aria-labelledby="estado-titulo">
        <h2 id="estado-titulo">Estado del proyecto</h2>
        <div class="tarjetas-estado">
            <article>
                <h3>Base Laravel</h3>
                <p>Proyecto configurado con Blade, Docker y una estructura MVC convencional.</p>
            </article>
            <article>
                <h3>Datos del TP1</h3>
                <p>Modelos, relaciones, migraciones e importador preparados para continuar.</p>
            </article>
            <article>
                <h3>En construcción</h3>
                <p>Explorador, autenticación y listas personalizadas pendientes.</p>
            </article>
        </div>
    </section>
@endsection
