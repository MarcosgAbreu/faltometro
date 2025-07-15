<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\GradeController;

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

    Route::resource('materias', SubjectController::class);

    Route::post('materias/{subject}/absences', [AbsenceController::class, 'store'])->name('absences.store');
    
    // A rota para excluir uma falta específica
    Route::delete('absences/{absence}', [AbsenceController::class, 'destroy'])->name('absences.destroy');

    // ROTAS PARA A CALCULADORA DE NOTAS
    Route::post('materias/{subject}/grades', [GradeController::class, 'store'])->name('grades.store');
    Route::patch('grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
    Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
});

require __DIR__.'/auth.php';
