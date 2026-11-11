

@extends('layout.layout')
@section('contenido')

    <h1>Personajes favoritos</h1>
    <div class="container">
        
        <h1>⭐ Mis Favoritos</h1>

        <nav style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: white; border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 8px;">
         <!--    <div>
                <a href="{{ url('/') }}" style="text-decoration: none; font-weight: bold; color: #3182ce;">← Volver al inicio</a>
            </div>
 -->
            <div style="display: flex; align-items: center; gap: 15px;margin-left:auto">
                <span style="color: #4a5568;">Hola, <strong>{{ Auth::user()->name ?? 'Invitado' }}</strong></span>

                {{-- Formulario POST para cerrar sesión --}}
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: #e53e3e; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </nav>


        @if(session('success'))
        <div style="background: #c6f6d5; color: #22543d; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Verificamos si la variable $favorites viene del controlador o usamos Auth directamente --}}
        @php
        $userFavorites = $favorites ?? Auth::user()->favorites()->with('favorable')->get();
        @endphp

        @forelse($userFavorites as $favorite)
        <div class="card">
            <div class="info">
                @if($favorite->favorable)
                {{-- Mostramos el nombre o título dependiendo de la entidad polimórfica --}}
                <h3>{{ $favorite->favorable->name ?? $favorite->favorable->title ?? 'Elemento sin nombre' }}</h3>
                <span class="badge">{{ class_basename($favorite->favorable_type) }}</span>
                @else
                <span style="color: red;">El elemento original ya no existe.</span>
                @endif
            </div>

            <div>
                {{-- Formulario para eliminar el favorito mediante DELETE --}}
                <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este favorito?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Eliminar</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty">
            <p>No tienes elementos guardados en tus favoritos todavía.</p>
        </div>
        @endforelse
    </div>
@endsection
