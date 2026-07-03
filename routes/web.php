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

Route::middleware(['auth', 'role:coordinador'])->group(function () {
    Route::get('/coordinador/dashboard', [DashboardController::class, 'coordinador'])->name('coordinador.dashboard');
});

Route::middleware(['auth', 'role:asesor'])->group(function () {
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('asesor.dashboard');
    Route::get('/asesor/documentos/{id}/descargar', [AsesorDocumentoController::class, 'descargar'])->name('asesor.documentos.descargar');
    Route::post('/asesor/documentos/{id}/revisar', [AsesorDocumentoController::class, 'revisar'])->name('asesor.documentos.revisar');
});

Route::middleware(['auth', 'role:alumno'])->group(function () {
    Route::get('/alumno/dashboard', [DashboardController::class, 'alumno'])->name('alumno.dashboard');
    Route::post('/alumno/documentos', [AlumnoDocumentoController::class, 'store'])->name('alumno.documentos.store');
});

require __DIR__.'/auth.php';
