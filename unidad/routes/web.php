<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\ResidentesController;
use App\Http\Controllers\VisitantesController;
use App\Http\Controllers\VisitasController;

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

// Rutas para Departamentos
Route::get('/departamentos', [DepartamentosController::class, 'index'])->name("departamentos.index");
Route::get('/departamentos/create', [DepartamentosController::class, 'create'])->name('departamentos.create');
Route::post('/departamentosadd', [DepartamentosController::class, 'store'])->name('departamentos.store');

// Rutas para Personas
Route::get('/personas', [PersonasController::class, 'index'])->name('personas.index');
Route::get('personas/create', [PersonasController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonasController::class, 'store'])->name('personas.store');

// Rutas para visitantes
Route::get('/visitantes', [VisitantesController::class, 'index'])->name('visitantes.index');
Route::get('/visitantes/create', [VisitantesController::class, 'create'])->name('visitantes.create');
Route::post('/visitantesadd', [VisitantesController::class, 'store'])->name('visitantes.store');

// Rutas para residentes
Route::get('/residentes', [ResidentesController::class, 'index'])->name('residentes.index');
Route::get('/residentes/create', [ResidentesController::class, 'create'])->name('residentes.create');
Route::post('/residentesadd', [ResidentesController::class, 'store'])->name('residentes.store');

// Rutas para visitas
Route::get('/visitas', [VisitasController::class, 'index'])->name('visitas.index');
Route::get('/visitas/create', [VisitasController::class, 'create'])->name('visitas.create');
Route::post('visitasadd',[VisitasController::class, 'store'])->name('visitas.store');

require __DIR__.'/auth.php';
