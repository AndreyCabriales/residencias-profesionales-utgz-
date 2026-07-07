<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return 'pong';
});

Route::get('/', function () {
    return view('welcome');
});

Route::view('/privacidad', 'privacidad')->name('privacidad');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('coordinador')) {
        return redirect()->route('coordinador.dashboard');
    } elseif ($user->hasRole('servicios_escolares')) {
        return redirect()->route('servicios_escolares.dashboard');
    } elseif ($user->hasRole('asesor')) {
        return redirect()->route('asesor.dashboard');
    } elseif ($user->hasRole('alumno')) {
        return redirect()->route('alumno.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Frontend Calendario
    Route::get('/calendario', function () {
        $alumnos = [];
        if (auth()->user()->hasRole('asesor') && auth()->user()->asesor) {
            $alumnos = App\Models\Alumno::whereHas('asignacion', function ($q) {
                $q->where('asesor_id', auth()->user()->asesor->id);
            })->with('user')->get();
        }
        $modalidades = App\Models\CatalogoItem::whereHas('catalogo', function($q) {
            $q->where('nombre', 'modalidad_asesoria');
        })->get();
        
        return view('calendario.index', compact('alumnos', 'modalidades'));
    })->name('calendario.index');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlumnoDocumentoController;
use App\Http\Controllers\AsesorDocumentoController;
use App\Http\Controllers\NotificacionController;

Route::middleware(['auth'])->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::get('/notificaciones/{id}/leer', [NotificacionController::class, 'leer'])->name('notificaciones.leer');
    Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'leerTodas'])->name('notificaciones.leer_todas');
});

use App\Http\Controllers\CoordinadorAlumnoController;
use App\Http\Controllers\CoordinadorAsesorController;

Route::middleware(['auth', 'role:coordinador'])->group(function () {
    Route::get('/coordinador/dashboard', [DashboardController::class, 'coordinador'])->name('coordinador.dashboard');
    
    // Rutas para la gestión de alumnos
    Route::get('/coordinador/alumnos', [CoordinadorAlumnoController::class, 'index'])->name('coordinador.alumnos.index');
    Route::get('/coordinador/alumnos/crear', [CoordinadorAlumnoController::class, 'create'])->name('coordinador.alumnos.create');
    Route::post('/coordinador/alumnos', [CoordinadorAlumnoController::class, 'store'])->name('coordinador.alumnos.store');
    Route::get('/coordinador/alumnos/{alumno}/editar', [CoordinadorAlumnoController::class, 'edit'])->name('coordinador.alumnos.edit');
    Route::put('/coordinador/alumnos/{alumno}', [CoordinadorAlumnoController::class, 'update'])->name('coordinador.alumnos.update');
    // Rutas para la gestión de asesores
    Route::get('/coordinador/asesores', [CoordinadorAsesorController::class, 'index'])->name('coordinador.asesores.index');
    Route::get('/coordinador/asesores/crear', [CoordinadorAsesorController::class, 'create'])->name('coordinador.asesores.create');
    Route::post('/coordinador/asesores', [CoordinadorAsesorController::class, 'store'])->name('coordinador.asesores.store');
    Route::get('/coordinador/asesores/{asesor}/editar', [CoordinadorAsesorController::class, 'edit'])->name('coordinador.asesores.edit');
    Route::put('/coordinador/asesores/{asesor}', [CoordinadorAsesorController::class, 'update'])->name('coordinador.asesores.update');
});

Route::middleware(['auth', 'role:asesor'])->group(function () {
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('asesor.dashboard');
    Route::get('/asesor/documentos/{documento}/descargar', [AsesorDocumentoController::class, 'descargar'])->name('asesor.documentos.descargar');
    Route::post('/asesor/documentos/{documento}/revisar', [AsesorDocumentoController::class, 'revisar'])->name('asesor.documentos.revisar');
});

Route::middleware(['auth', 'role:alumno'])->group(function () {
    Route::get('/alumno/dashboard', [DashboardController::class, 'alumno'])->name('alumno.dashboard');
    Route::post('/alumno/documentos', [AlumnoDocumentoController::class, 'store'])->name('alumno.documentos.store');
});

use App\Http\Controllers\ServiciosEscolaresController;

Route::middleware(['auth', 'role:servicios_escolares'])->group(function () {
    Route::get('/servicios-escolares/dashboard', [ServiciosEscolaresController::class, 'dashboard'])->name('servicios_escolares.dashboard');
    Route::post('/servicios-escolares/documentos/{documento}/revisar', [ServiciosEscolaresController::class, 'revisar'])->name('servicios_escolares.documentos.revisar');
});

require __DIR__.'/auth.php';

// Rutas de API propias (para cumplir rúbrica de APIs REST)
Route::prefix('api/v1')->middleware('auth')->group(function () {
    Route::get('/alumnos/stats', [\App\Http\Controllers\Api\AlumnoApiController::class, 'stats'])->name('api.v1.alumnos.stats');
    
    // Calendario y Asesorias
    Route::get('/calendario', [\App\Http\Controllers\Api\CalendarioController::class, 'index'])->name('api.v1.calendario.index');
    
    Route::post('/asesorias', [\App\Http\Controllers\Api\AsesoriaController::class, 'store'])->name('api.v1.asesorias.store');
    Route::get('/asesorias/{id}', [\App\Http\Controllers\Api\AsesoriaController::class, 'show'])->name('api.v1.asesorias.show');
    Route::put('/asesorias/{id}', [\App\Http\Controllers\Api\AsesoriaController::class, 'update'])->name('api.v1.asesorias.update');
    Route::delete('/asesorias/{id}', [\App\Http\Controllers\Api\AsesoriaController::class, 'destroy'])->name('api.v1.asesorias.destroy');
    Route::post('/asesorias/{id}/comentarios', [\App\Http\Controllers\Api\AsesoriaController::class, 'storeComentario'])->name('api.v1.asesorias.comentarios.store');
    Route::post('/asesorias/{id}/confirmar', [\App\Http\Controllers\Api\AsesoriaController::class, 'confirmar'])->name('api.v1.asesorias.confirmar');
    
    // Dashboard Progress
    Route::get('/dashboard/progreso', [\App\Http\Controllers\Api\DashboardApiController::class, 'progreso'])->name('api.v1.dashboard.progreso');
    Route::post('/dashboard/finalizar-seguimiento', [\App\Http\Controllers\Api\DashboardApiController::class, 'finalizarSeguimiento'])->name('api.v1.dashboard.finalizar_seguimiento');
});
