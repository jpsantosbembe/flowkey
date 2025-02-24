<?php

use App\Http\Controllers\GuardhouseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Rotas de Guardhouses
    Route::get('/guardhouses', [GuardhouseController::class, 'index'])
        ->name('guardhouses.index')
        ->middleware('permission:guardhouses.index');

    Route::get('/guardhouses/create', [GuardhouseController::class, 'create'])
        ->name('guardhouses.create')
        ->middleware('permission:guardhouses.create');

    Route::post('/guardhouses', [GuardhouseController::class, 'store'])
        ->name('guardhouses.store')
        ->middleware('permission:guardhouses.create');

    Route::get('/guardhouses/{guardhouse}', [GuardhouseController::class, 'show'])
        ->name('guardhouses.show')
        ->middleware('permission:guardhouses.show');

    Route::get('/guardhouses/{guardhouse}/edit', [GuardhouseController::class, 'edit'])
        ->name('guardhouses.edit')
        ->middleware('permission:guardhouses.edit');

    Route::patch('/guardhouses/{guardhouse}', [GuardhouseController::class, 'update'])
        ->name('guardhouses.update')
        ->middleware('permission:guardhouses.edit');
});
