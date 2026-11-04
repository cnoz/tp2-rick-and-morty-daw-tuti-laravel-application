<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rick and Morty Explorer')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="encabezado-app">
        <a href="{{ route('home') }}" class="marca">
            <img src="{{ asset('images/logo_Rick_and_Morty.svg.webp') }}" alt="Rick and Morty" class="logo-app">
        </a>
    </header>

    <main class="contenido-principal">
        @yield('content')
    </main>

    <footer class="pie-pagina">
        <p>Trabajo Práctico Nº 2 - Desarrollo de Aplicaciones Web</p>
    </footer>
</body>
</html>
