<?php

use App\Http\Controllers\CoordinatorKeysController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/coordinatorkeys', [CoordinatorKeysController::class, 'index'])
        ->name('coordinatorkeys.index')
        ->middleware('permission:coordinatorkeys.index');

    Route::get('/coordinatorkeys/create', [CoordinatorKeysController::class, 'create'])
     ->name('coordinatorkeys.create')
        ->middleware('permission:coordinatorkeys.create');

    Route::post('/coordinatorkeys', [CoordinatorKeysController::class, 'store'])
        ->name('coordinatorkeys.store')
        ->middleware('permission:coordinatorkeys.create');

    Route::get('/coordinatorkeys/{coordinatorsKeys}', [CoordinatorKeysController::class, 'show'])
        ->name('coordinatorkeys.show')
        ->middleware('permission:coordinatorkeys.show');

    Route::get('/coordinatorkeys/{coordinatorsKeys}/edit', [CoordinatorKeysController::class, 'edit'])
        ->name('coordinatorkeys.edit')
        ->middleware('permission:coordinatorkeys.edit');

    Route::patch('/coordinatorkeys/{coordinatorsKeys}', [CoordinatorKeysController::class, 'update'])
        ->name('coordinatorkeys.update')
        ->middleware('permission:coordinatorkeys.edit');

    Route::get('/mykeys', [CoordinatorKeysController::class, 'mykeys'])
        ->name('coordinatorkeys.mykeys')
        ->middleware('permission:keyauthorizations.index');

    Route::get('/search-discentes', [CoordinatorKeysController::class, 'searchUsers'])
        ->name('coordinatorkeys.search-users')
        ->middleware('permission:keyauthorizations.index');
});
