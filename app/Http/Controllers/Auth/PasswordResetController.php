<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //dd('Llegó a la ruta de reseteo');
        return view('auth.forgot-password');
    }

    /**
     * Store a newly created resource in storage.
     */
    // 1. Muestra la vista para solicitar el correo
    public function store(Request $request)
    {
        $request->validate(['email'=>['required', 'email']]);
        // Envía el correo usando el sistema nativo de Laravel
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status == Password::RESET_LINK_SENT
            ? back()->with(['status'=>__($status)])
            : back()->withErrors(['email'=>__($status)]);
    }

    /**
     * Muestra el formulario para ingresar la nueva contraseña (recibe el token).
     */
   public function edit(Request $request, $token)
     {
        //dd($token, $request->email);
        // CORREGIDO: ahora retorna la vista pasando el token y el email por la URL
        
        return view('auth.reset-password', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }

/*     public function edit(Request $request, $token)
{
    // Esto te mostrará en pantalla el token exacto y el email que llegaron por la URL
    return "Token recibido: " . $token . " - Email: " . $request->email;
} */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        // dd('¡Llegó al método update con éxito!', $request->all());

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                
                $user->save();

                event(new PasswordReset($user));
            }
        );
        
        // dd($status);

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


}
