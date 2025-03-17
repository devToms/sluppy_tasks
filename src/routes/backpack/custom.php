<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaskCrudController;
// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.



Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    // Dodaj tutaj trasy CRUD
    Route::crud('task', TaskCrudController::class);
}); // this should be the absolute last line of this file
Route::get('admin/test', function() {
    return 'Test działa';
});



/**
 * DO NOT ADD ANYTHING HERE.
 */
/**
 * DO NOT ADD ANYTHING HERE.
 */


