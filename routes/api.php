<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí defines las rutas API de tu aplicación.
|
*/

Route::middleware('api')->get('/prueba', function () {
    return response()->json(['mensaje' => 'API funcionando']);
});
