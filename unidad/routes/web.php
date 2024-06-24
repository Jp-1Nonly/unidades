<?php

use App\Http\Controllers\DepartamentosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


route::get('/departamentos', [DepartamentosController::class, 'index'])->name("departamentos");


Route::get('/departamentos/create', [DepartamentosController::class, 'create'])->name('departamentos.create');
Route::post('/departamentosadd', [DepartamentosController::class, 'store'])->name('departamentos.store');
