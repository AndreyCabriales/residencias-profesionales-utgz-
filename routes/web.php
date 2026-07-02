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

Route::middleware(['auth', 'role:coordinador'])->group(function () {
    Route::get('/coordinador/dashboard', function () {
        return view('coordinador.dashboard');
    })->name('coordinador.dashboard');
});

Route::middleware(['auth', 'role:asesor'])->group(function () {
    Route::get('/asesor/dashboard', function () {
        return view('asesor.dashboard');
    })->name('asesor.dashboard');
});

Route::middleware(['auth', 'role:alumno'])->group(function () {
    Route::get('/alumno/dashboard', function () {
        return view('alumno.dashboard');
    })->name('alumno.dashboard');
});

require __DIR__.'/auth.php';
