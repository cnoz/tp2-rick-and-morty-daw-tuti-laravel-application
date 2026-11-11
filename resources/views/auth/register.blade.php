@extends('layout.layout')
@section('contenido')
    <div style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
    <h2>Registro de Usuario</h2>

    @if($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label>Nombre:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Correo Electrónico:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Contraseña:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 10px;">
            <label>Confirmar Contraseña:</label><br>
            <input type="password" name="password_confirmation" required style="width: 100%; padding: 8px;">
        </div>
        <button type="submit" style="padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer;">Registrarse</button>
    </form>

    <p style="margin-top: 15px;">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</div>
@endsection