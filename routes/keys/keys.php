<?php

use App\Http\Controllers\KeyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Rotas de Keys
    Route::get('/keys', [KeyController::class, 'index'])
        ->name('keys.index')
        ->middleware('permission:keys.index');

    Route::get('/keys/create', [KeyController::class, 'create'])
        ->name('keys.create')
        ->middleware('permission:keys.create');

    Route::post('/keys', [KeyController::class, 'store'])
        ->name('keys.store')
        ->middleware('permission:keys.create');

    Route::get('/keys/{key}', [KeyController::class, 'show'])
        ->name('keys.show')
        ->middleware('permission:keys.show');

    Route::get('/keys/{key}/edit', [KeyController::class, 'edit'])
        ->name('keys.edit')
        ->middleware('permission:keys.edit');

    Route::patch('/keys/{key}', [KeyController::class, 'update'])
        ->name('keys.update')
        ->middleware('permission:keys.edit');
});
