@extends('layout.layout')

@section('contenido')

<div class="container">
    <h1>Mi Perfil</h1>
    @auth
        @if(auth()->user()->is_admin)
            <a href="{{ route('users.index') }}">Panel de Administración</a>
        @endif
    @endauth
    @if (session('status'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label>Mi Nombre:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <label>Mi Correo Electrónico:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <label>Nueva Contraseña (dejar en blanco si no deseas cambiarla):</label>
            <input type="password" name="password">
            @error('password') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <label>Confirmar Nueva Contraseña:</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit" style="margin-top: 15px;">Guardar Mis Cambios</button>
    </form>
       <p style="margin-top: 20px;">
        <a href="{{ route('favorites.index') }}">← Volver al listado</a>
    </p>
</div>
@endsection