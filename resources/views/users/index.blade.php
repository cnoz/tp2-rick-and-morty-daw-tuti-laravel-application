@extends('layout.layout') {{-- O el nombre de tu layout principal --}}

@section('contenido')
<p>Valor de is_admin: {{ auth()->user()->is_admin ?? 'No definido' }}</p>
<div class="container">
    <h1>Panel de Administración - Usuarios</h1>

    @if (session('status'))
        <div class="alert alert-success" style="color: green;">
            {{ session('status') }}
        </div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}">Editar</a>
                        
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" style="color: red;">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection