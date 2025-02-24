<?php

use App\Http\Controllers\CampusController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/campuses', [CampusController::class, 'index'])
        ->name('campuses.index')
        ->middleware('permission:campuses.index');

    Route::get('/campuses/create', [CampusController::class, 'create'])
        ->name('campuses.create')
        ->middleware('permission:campuses.create');

    Route::post('/campuses', [CampusController::class, 'store'])
        ->name('campuses.store')
        ->middleware('permission:campuses.create');

    Route::get('/campuses/{campus}', [CampusController::class, 'show'])
        ->name('campuses.show')
        ->middleware('permission:campuses.show');

    Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit'])
        ->name('campuses.edit')
        ->middleware('permission:campuses.edit');

    Route::patch('/campuses/{campus}', [CampusController::class, 'update'])
        ->name('campuses.update')
        ->middleware('permission:campuses.edit');
});
