@extends('layout.layout')
@section('contenido')

<div style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
        <h2>Recuperar Contraseña</h2>

        @if (session('status'))
            <div style="color: green; margin-bottom: 15px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px;">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 8px;">
                @error('email')
                    <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" style="padding: 10px 15px;">Enviar Enlace de Recuperación</button>
        </form>
    </div>
@endsection
