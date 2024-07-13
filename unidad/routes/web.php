<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\VisitantesController;

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

//Rutas para Departamentos
Route::get('/departamentos', [DepartamentosController::class, 'index'])->name("departamentos");
Route::get('/departamentos/create', [DepartamentosController::class, 'create'])->name('departamentos.create');
Route::post('/departamentosadd', [DepartamentosController::class, 'store'])->name('departamentos.store');


//Rutas para Personas
Route::get('/personas', [PersonasController::class, 'index'])->name('personas');
Route::get('personas/create', [PersonasController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonasController::class, 'store'])->name('personas.store');

//Rutas para visitantes
Route:: get('/visitantes', [VisitantesController::class, 'index'])->name('visitantes');
Route::get('/visitantes/create', [VisitantesController::class, 'create'])->name('visitantes.create');
Route::post('/visitantes', [VisitantesController::class, 'store'])->name('visitantes.store');






require __DIR__.'/auth.php';
