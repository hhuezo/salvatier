<?php

use App\Http\Controllers\administracion\AbogadoController;
use App\Http\Controllers\administracion\AsesoriaController;
use App\Http\Controllers\administracion\NotificacionController;
use App\Http\Controllers\administracion\OperadorController;
use App\Http\Controllers\seguridad\PermissionController;
use App\Http\Controllers\seguridad\RoleController;
use App\Http\Controllers\seguridad\UserController;
use App\Http\Controllers\usuario\AsesoriaUsuarioController;
use App\Http\Controllers\usuario\PagoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //seguridad
    Route::resource('seguridad/permission', PermissionController::class);
    Route::post('seguridad/role/update_permission', [RoleController::class, 'updatePermission']);
    Route::resource('seguridad/role', RoleController::class);
    Route::post('seguridad/user/update_password/{id}', [UserController::class, 'updatePassword']);
    Route::get('seguridad/configuracion', [UserController::class, 'configuracion']);
    Route::post('seguridad/configuracion', [UserController::class, 'configuracionStore']);
    Route::resource('seguridad/user', UserController::class);


    //administracion
    Route::resource('administracion/abogado', AbogadoController::class);
    Route::resource('administracion/operador', OperadorController::class);
    Route::post('administracion/asesoria/confirmar', [AsesoriaController::class, 'confirmar']);
    Route::post('administracion/asesoria/reagendar', [AsesoriaController::class, 'reagendar']);
    Route::resource('administracion/asesoria', AsesoriaController::class);
    Route::resource('administracion/notificacion', NotificacionController::class);


    Route::get('usuario/asesoria/agendadas', [AsesoriaUsuarioController::class, 'agendadas']);
    Route::get('usuario/sucursales', [AsesoriaUsuarioController::class, 'sucursales']);
    Route::post('usuario/asesoria/pago/{id}', [AsesoriaUsuarioController::class, 'pago']);
    Route::get('usuario/asesoria/pago_finalizado', [AsesoriaUsuarioController::class, 'pago_finalizado']);
    Route::get('usuario/asesoria/get_territorio/{id}', [AsesoriaUsuarioController::class, 'getTerritorio']);
    Route::resource('usuario/asesoria', AsesoriaUsuarioController::class);
});
