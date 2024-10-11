<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Ruta de inicio
Route::get('/', function () {
    return view('home');
})->name('welcome'); // Nombre para la ruta de inicio

// Rutas de autenticación
Auth::routes();

// Rutas relacionadas con usuarios, protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home'); // Listar usuarios
    Route::get('/home', [UserController::class, 'showUsuarios'])->name('home'); // Mostrar usuarios

    Route::post('/home/{id}/assign-role', [UserController::class, 'assignRole'])->name('assign.role'); // Asignar rol a un usuario
    Route::post('/home/{id}/remove-role', [UserController::class, 'removeRole'])->name('remove.role'); // Eliminar rol de un usuario

    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes'); // Mostrar estudiantes
    Route::get('/estudiantes/create', [EstudianteController::class, 'create'])->name('estudiantes.create'); // Crear estudiante
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store'); // Almacenar estudiante
    Route::get('/estudiantes/{estudiante}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit'); // Editar estudiante
    Route::put('/estudiantes/{estudiante}', [EstudianteController::class, 'update'])->name('estudiantes.update'); // Actualizar estudiante
    Route::delete('/estudiantes/{estudiante}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy'); // Eliminar estudiante
});

// Redirigir a la página de inicio después de iniciar sesión
Route::get('/home', [HomeController::class, 'index'])->name('home');
