<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Task;


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/tasks', Task::class)->name('tasks.index');
});




