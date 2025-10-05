<?php

use App\Http\Controllers\administracion\AbogadoController;
use App\Http\Controllers\administracion\AsesoriaController;
use App\Http\Controllers\administracion\ContratoController;
use App\Http\Controllers\administracion\EmpresaController;
use App\Http\Controllers\administracion\EncargadoPagoController;
use App\Http\Controllers\Administracion\ModoAsesoriaController;
use App\Http\Controllers\administracion\NotificacionController;
use App\Http\Controllers\administracion\OficinaController;
use App\Http\Controllers\administracion\PagoController;
use App\Http\Controllers\seguridad\PermissionController;
use App\Http\Controllers\seguridad\RoleController;
use App\Http\Controllers\seguridad\UserController;
use App\Http\Controllers\usuario\AsesoriaUsuarioController;
use Illuminate\Support\Facades\Auth;
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
    Route::resource('seguridad/user', UserController::class);


    //administracion
    Route::resource('administracion/abogado', AbogadoController::class);
    Route::post('administracion/asesoria/confirmar', [AsesoriaController::class, 'confirmar']);
    Route::post('administracion/asesoria/reagendar', [AsesoriaController::class, 'reagendar']);
    Route::resource('administracion/asesoria', AsesoriaController::class);
    Route::resource('notificacion', NotificacionController::class);
    Route::resource('administracion/modo_asesoria', ModoAsesoriaController::class);


    Route::post('usuario/mis_notificaiones/leido/{id}', [AsesoriaUsuarioController::class, 'mis_notificaiones_leido'])->name('mis_notificaiones_leido');
    Route::get('usuario/mis_notificaiones', [AsesoriaUsuarioController::class, 'mis_notificaiones'])->name('mis_notificaiones');
    Route::get('usuario/asesoria/agendadas', [AsesoriaUsuarioController::class, 'agendadas']);
    Route::get('usuario/sucursales', [AsesoriaUsuarioController::class, 'sucursales']);
    Route::post('usuario/asesoria/pago/{id}', [AsesoriaUsuarioController::class, 'pago']);
    Route::get('usuario/asesoria/pago_finalizado', [AsesoriaUsuarioController::class, 'pago_finalizado']);
    Route::get('usuario/asesoria/get_territorio/{id}', [AsesoriaUsuarioController::class, 'getTerritorio']);
    Route::resource('usuario/asesoria', AsesoriaUsuarioController::class);


    Route::resource('contrato', ContratoController::class);
    Route::get('administracion/pago/previsualizacion', [PagoController::class, 'previsualizacion'])->name('pago.previsualizacion');
    Route::resource('pago', PagoController::class);
    Route::resource('empresa', EmpresaController::class);
    Route::resource('encargado_pago', EncargadoPagoController::class);
     Route::resource('oficina', OficinaController::class);

    /*Route::get('administracion/servicio_show/{id}', [PagoController::class, 'servicio_show'])->name('servicio.show');
    Route::get('administracion/pago/previsualizacion', [PagoController::class, 'previsualizacion'])->name('pago.previsualizacion');
    Route::post('administracion/servicio_store', [PagoController::class, 'servicio_store'])->name('servicio.store');
    Route::resource('administracion/pago', PagoController::class);*/
});
