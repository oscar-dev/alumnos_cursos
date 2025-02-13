<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('estudiantes', EstudianteController::class);
Route::post('estudiantes/{estudiante}/asignar-curso', [EstudianteController::class, 'asignarCurso']);
Route::get('estudiantes/{estudiante}/cursos', [EstudianteController::class, 'cursos']);
Route::get('estudiantes/{estudiante_di}/cursos-no-asignados', [EstudianteController::class, 'cursosNoAsignados']);
Route::apiResource('cursos', CursoController::class);


