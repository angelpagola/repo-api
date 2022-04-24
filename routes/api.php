<?php

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
    Route::post('/login', 'login')->name('usuario.login');
    Route::post('/signup', 'signup')->name('usuario.signup');
    Route::get('/perfil/{usuario_id}', 'show')->name('usuario.show');
    Route::get('/perfil/avatar/{usuario_id}', 'avatar')->name('usuario.avatar');
    Route::get('/perfil/interes/{usuario_id}', 'interes')->name('usuario.interes');
    Route::post('/perfil/update/{usuario}', 'usuarioUpdate')->name('usuario.update');
    Route::post('/perfil/avatar/update/{usuario}', 'avatarUpdate')->name('usuario.avatar.update');
    Route::delete('/perfil/interes/{tag_id}', 'interesDelete')->name('usuario.interes.delete');
});

Route::prefix('/home')->controller(HomeController::class)->group(function () {
    Route::get('/{id}', 'index')->name('home.index');
    Route::post('/buscar/', 'buscar')->name('proyecto.buscar');

});

Route::prefix('/proyecto')->controller(ProyectoController::class)->group(function () {
    Route::get('/like/{proy_id}/{user_id}', 'darLike')->name('proyecto.like');
    Route::get('/fav/{proy_id}/{user_id}', 'agregarAFav')->name('proyecto.fav');
    Route::get('/valoracion/{proyecto_id}/{usuario_id}', 'valoracion')->name('proyecto.valoracion');
    Route::get('/{proyecto_id}', 'show')->name('proyecto.show');
    Route::get('/favorito/{proyecto_id}/{usuario_id}', 'favorito')->name('proyecto.favorito');
    Route::get('/recomendacion/{proyecto_id}', 'recomendados')->name('proyecto.recomendados');
    Route::get('/usuario/{usuario}', 'index')->name('proyecto.index');
    Route::get('/userinfo/{usuario}', 'datosUsuario')->name('proyecto.userinfo');
    Route::post('/crear', 'store')->name('proyecto.store');
    Route::post('/editar/{proyecto_id}', 'update')->name('proyecto.update');
    Route::delete('/eliminar/{proyecto_id}', 'destroy')->name('proyecto.destroy');
    Route::get('/reportar/motivos', 'motivos')->name('proyecto.motivos');
    Route::post('/reportar/', 'reportar')->name('proyecto.reportar');
});

Route::prefix('/favorito')->controller(FavoritoController::class)->group(function () {
    Route::get('/lista/{usuario_id}', 'index')->name('favorito.index');
    Route::post('/agregar/{proyecto_id}/{usuario_id}', 'store')->name('favorito.store');
    Route::delete('/eliminar/{proyecto_id}/{usuario_id}', 'destroy')->name('favorito.destroy');
});
