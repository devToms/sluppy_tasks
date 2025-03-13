<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/pets', [PetController::class, 'index'])->name('pets.index'); // Lista zwierząt
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create'); // Formularz dodawania
Route::post('/pets', [PetController::class, 'store'])->name('pets.store'); // Dodanie zwierzaka

Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show'); // Szczegóły zwierzaka
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit'); // Formularz edycji
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update'); // Aktualizacja zwierzaka

Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy'); // Usunięcie zwierzaka
