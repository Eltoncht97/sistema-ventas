<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [\App\Http\Controllers\UserController::class, 'Login'])->name('login');

// Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('productos', \App\Http\Controllers\ProductoController::class);
    Route::put('set-like/{producto}', [\App\Http\Controllers\ProductoController::class, 'setLike'])->name('set-like');
    Route::put('set-dislike/{producto}', [\App\Http\Controllers\ProductoController::class, 'setDislike'])->name('set-dislike');
    Route::put('set-imagen/{producto}', [\App\Http\Controllers\ProductoController::class, 'setImagen'])->name('set-imagen');
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'Logout'])->name('logout');
// });

