@extends('layout.layout')
@section('contenido')
    <div style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
    <h2>Iniciar Sesión</h2>

    @if($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label>Correo Electrónico:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Contraseña:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px;">
        </div>
        <button type="submit" style="padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer;">Entrar</button>
    </form>
    <p style="margin-top: 15px;">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
</div>
@endsection