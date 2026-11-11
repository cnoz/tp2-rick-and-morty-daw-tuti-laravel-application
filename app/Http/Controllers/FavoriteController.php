<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FavoriteController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra el listado de favoritos del usuario autenticado.
     */
    public function index()
    {

       /** @var User $user */
        $user = Auth::user();
        
        // Usamos la variable $user en lugar de llamar otra vez a Auth::user()
        $favorites = $user->favorites()->with('favorable')->get();

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Almacena o alterna un elemento como favorito.
     */
     public function store(Request $request, string $type, int $id)
    { 
        // 1. Mapear el string recibido por URL a su modelo correspondiente
        // 1. Mapear el string recibido por URL a su modelo correspondiente
         $modelMap = [
            'character' => \App\Models\Character::class,
            'location'  => \App\Models\Location::class,
            'episode'   => \App\Models\Episode::class,
        ];

        if (!array_key_exists($type, $modelMap)) {
            abort(404, 'Tipo de recurso no válido.');
        }

        $modelClass = $modelMap[$type]; 
        
        // Buscar el recurso
         $resource = $modelClass::findOrFail($id); 

        /** @var User $user */
         $user = Auth::user(); 

        // 2. Crear o asegurar que existe el favorito usando la variable $user
        $user->favorites()->firstOrCreate([
            'favorable_id' => $resource->getKey(),
            'favorable_type' => $modelClass,
        ]);

        return back()->with('success', 'Añadido a favoritos correctamente.');
    }

    /**
     * Elimina un favorito específico.
     */
    public function destroy(Favorite $favorite)
    {
        // Aplicar la política de autorización (solo el dueño puede borrarlo)
        $this->authorize('delete', $favorite);

        $favorite->delete();

        return back()->with('success', 'Eliminado de favoritos.');
    }




}
