<?php

use App\Http\Controllers\UserController;

Route::middleware(['auth'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('users.index')
        ->middleware('permission:users.index');

    Route::get('/create', [UserController::class, 'create'])
        ->name('users.create')
        ->middleware('permission:users.create');

    Route::post('/', [UserController::class, 'store'])
        ->name('users.store')
        ->middleware('permission:users.create');

    Route::get('/{user}', [UserController::class, 'show'])
        ->name('users.show')
        ->middleware('permission:users.show');

    Route::get('/edit/{user}', [UserController::class, 'edit'])
        ->name('users.edit')
        ->middleware('permission:users.edit');

    Route::patch('/{user}', [UserController::class, 'update'])
        ->name('users.update')
        ->middleware('permission:users.edit');
});
