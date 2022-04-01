<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\UsuarioController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/usuario')->controller(UsuarioController::class)->group(function () {
    Route::post('login', 'login')->name('usuario.login');
    Route::post('signup', 'signup')->name('usuario.signup');
    Route::get('/perfil/avatar/{id}', 'avatar')->name('usuario.avatar');
    Route::get('/perfil/interes/{id}', 'interes')->name('usuario.interes');
    Route::get('/perfil/{id}', 'show')->name('usuario.show');
});

Route::prefix('/home')->controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
});


Route::prefix('/proyecto')->controller(ProyectoController::class)->group(function () {
    Route::get('/', 'index')->name('proyecto.index');
    Route::get('/recomendacion/{id}', 'recomendados')->name('proyecto.recomendados');
    Route::get('/{id}', 'show')->name('proyecto.show');
    Route::post('/', 'store')->name('proyecto.store');
    Route::put('/{id}', 'update')->name('proyecto.update');
    Route::delete('/{id}', 'destroy')->name('proyecto.destroy');
});

/*Route::prefix('/favorito')->controller(FavoritoController::class)->group(function () {
    Route::get('/', 'index')->name('favorito.index');
    Route::get('/{id}', 'show')->name('favorito.show');
});*/
