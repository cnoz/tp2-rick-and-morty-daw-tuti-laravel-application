<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

Route::view('/', 'home')->name('home');



//favoritos rutas
Route::middleware(['auth'])->prefix('favoritos')->name('favorites.')->group(function (){
    Route::get('/', [FavoriteController::class, 'index'])->name('index');
    Route::post('/{type}/{id}', [FavoriteController::class, 'store'])->name('store');
    Route::delete('/{favorite}', [FavoriteController::class, 'destroy'])->name('destroy');
});
// login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Ruta para cerrar sesión (requiere estar autenticado)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Ruta reseteo password
// Formulario para ingresar el correo
Route::get('forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
// Envía el enlace de recuperación al correo
Route::post('forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
// Formulario para ingresar la nueva contraseña (recibe el token por URL)
Route::get('reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');

// Actualiza la contraseña en la base de datos
Route::post('reset-password', [PasswordResetController::class, 'update'])->name('password.update');

// profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// route de adm de usuarios
//Route::resource('users', UserController::class);

// Panel de administración de usuarios (Protegido: Auth + AdminMiddleware)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
});