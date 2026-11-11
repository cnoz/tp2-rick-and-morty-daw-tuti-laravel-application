@extends('layout.layout')

@section('contenido')
<div class="container">
    <h1>Editar Usuario: {{ $user->name }}</h1>
    
    @if (session('status'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Nombre:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <label>Correo Electrónico:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <label>Nueva Contraseña (opcional):</label>
            <input type="password" name="password">
            @error('password') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <label>Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit" style="margin-top: 15px;">Actualizar Usuario</button>
    </form>

    <p style="margin-top: 20px;">
        <a href="{{ route('users.index') }}">← Volver al listado</a>
    </p>
</div>
@endsection