@extends('layout.layout')
@section('contenido')

<div style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label>Correo Electrónico</label>
        <input type="email" name="email" value="{{ $email ?? old('email') }}" required />
        @error('email')
            <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>



    <div>
        <label>Nueva Contraseña</label>
        <input type="password" name="password" required />
        @error('password')
            <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" required />
    </div>

    <button type="submit">Restablecer Contraseña</button>
</form>
</div>


@endsection