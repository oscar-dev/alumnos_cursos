<?php

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('estudiantes', [EstudianteController::class, 'list'])->name('estudiantes');
Route::get('cursos', [CursoController::class, 'list'])->name('cursos');