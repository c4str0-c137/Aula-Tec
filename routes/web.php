<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcontecimientoController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\AmbienteHorarioController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\mensajeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [AmbienteController::class, 'index'])->name('home')->middleware('auth');

Route::resource('Ambiente', AmbienteController::class)->middleware('auth');
Route::resource('Configuracion', ConfiguracionController::class)->middleware('auth');

Route::post('/guardar-configuracion', [ConfiguracionController::class, 'guardarConfiguracion'])->name('guardar_configuracion')->middleware('auth');

Route::get('/mostrar-vista', [ConfiguracionController::class, 'mostrarVista'])->name('mostrar_vista')->middleware('auth');

Route::resource('Horario', AmbienteHorarioController::class)->middleware('auth');

Route::get('/get-ambientes', [AmbienteController::class, 'getAmbientes'])->name('get.ambientes')->middleware('auth');

Route::get('/ambiente_horarios', [AmbienteHorarioController::class, 'index'])->name('ambiente_horarios.index')->middleware('auth');

Route::get('/Horario/create', [HorarioController::class, 'create'])->name('Horario.create')->middleware('auth');

Route::post('/ambiente_horarios', [AmbienteHorarioController::class, 'store'])->name('ambiente_horarios.store')->middleware('auth');

Route::put('/Ambiente/{ambiente}', [AmbienteController::class, 'update'])->name('ambiente.update')->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

//USUARIOS
Route::resource('users', UserController::class)
    ->except('create', 'edit')
    ->names('users');

//redireccion ala pagina de docente
Route::view('/docente', 'Docente.docente')->name('docente')->middleware('docente');
Route::get('/solicitud-reserva', [ReservaController::class, 'index'])->name('solicitud_reserva')->middleware('docente');
Route::get('/get-grupos', [ReservaController::class, 'getGrupos'])->name('getGrupos')->middleware('docente');
Route::post('/guardar-solicitud', [ReservaController::class, 'guardarSolicitud'])->name('guardar_solicitud')->middleware('docente');

Route::middleware(['auth'])->group(function() {
    Route::resource('mensaje', MensajeController::class);
    Route::resource('reserva', ReservaController::class);
    Route::get('/mensaje/detalle/{id}', [MensajeController::class, 'unico'])->name('mensaje.unico');
    Route::get('/solicitud', [ReservaController::class, 'solicitud'])->name('reserva.solicitud');

    Route::get('markAsRead', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');
    Route::post('/mark-as-read', [MensajeController::class, 'markNotification'])->name('markNotification');
});
Route::get('/mensaje/create', [MensajeController::class, 'create'])->name('mensaje.create')->middleware('auth');

Route::put('/Horario/{id}', [AmbienteHorarioController::class, 'update'])->name('Horario.update')->middleware('auth');

Route::get('/asignar-ambiente/{id}', [MensajeController::class, 'asignarAmbiente'])->name('asignarAmbiente')->middleware('auth');
Route::post('/buscar-ambientes', [MensajeController::class, 'buscarAmbientes'])->name('buscarAmbientes')->middleware('auth');
Route::post('/confirmar-reserva/{id}', [MensajeController::class, 'confirmarReserva'])->name('confirmarReserva')->middleware('auth');

Route::post('/get-ubicaciones', [MensajeController::class, 'getUbicaciones'])->name('getUbicaciones');
Route::post('/get-ambientes', [MensajeController::class, 'getAmbientes']);
Route::get('/docente/reserva-unica', [ReservaController::class, 'mostrarUnica'])->name('docente.unica')->middleware('auth.redirect');
Route::get('/reservas/pendientes', [ReservaController::class, 'showPendientes'])->name('reservas.pendientes')->middleware('auth');
Route::post('/confirmar-reserva/{id}/{action}', [ReservaController::class, 'confirmarSolicitud'])->name('confirmar-solicitud');