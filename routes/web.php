<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserHomeController;
/*
|--------------------------------------------------------------------------
| Página principal (pública)
|--------------------------------------------------------------------------
| Esta ruta carga la vista de bienvenida al acceder a la raíz del sitio.
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Redirección post-login según el rol
|--------------------------------------------------------------------------
| Esta ruta se activa después del login.
| Redirige al panel de admin (/admin) o a la vista de usuario (/user/home).
*/
Route::get('/redirect', function () {
    if (Auth::user()->role === 'admin') {
        return redirect('/admin'); // Aquí luego puedes poner la ruta real del panel Filament si es necesario
    }

    return redirect('/user/home');
})->middleware(['auth', 'verified'])->name('redirect');

/*
|--------------------------------------------------------------------------
| Rutas para usuarios autenticados
|--------------------------------------------------------------------------
| Estas rutas requieren sesión iniciada (auth).
*/
Route::middleware('auth')->group(function () {

    // Vista del perfil (editar, actualizar, eliminar)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vista principal del usuario (ya está funcionando)
    Route::get('/user/home', [UserHomeController::class, 'home'])->name('user.home');
    
    //Ruta para crear ticket
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    //Ruta para guardar el ticket (esta es la nueva)
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');


});

/*
|--------------------------------------------------------------------------
| Archivo de rutas de autenticación
|--------------------------------------------------------------------------
| Incluye las rutas de login, registro, recuperación de contraseña, etc.
*/
require __DIR__.'/auth.php';
