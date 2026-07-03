<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

require __DIR__.'/auth.php';
