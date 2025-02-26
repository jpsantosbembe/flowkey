<?php

use App\Http\Controllers\KeyAuthorizationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/keyauthorizations', [KeyAuthorizationController::class, 'index'])
        ->name('keyauthorizations.index')
        ->middleware('permission:keyauthorizations.index');

    Route::get('/keyauthorizations/create', [KeyAuthorizationController::class, 'create'])
        ->name('keyauthorizations.create')
        ->middleware('permission:keyauthorizations.create');

    Route::post('/keyauthorizations', [KeyAuthorizationController::class, 'store'])
        ->name('keyauthorizations.store')
        ->middleware('permission:keyauthorizations.create');

    Route::get('/keyauthorizations/{keyAuthorization}', [KeyAuthorizationController::class, 'show'])
        ->name('keyauthorizations.show')
        ->middleware('permission:keyauthorizations.show');

    Route::get('/keyauthorizations/{keyAuthorization}/edit', [KeyAuthorizationController::class, 'edit'])
        ->name('keyauthorizations.edit')
        ->middleware('permission:keyauthorizations.edit');

    Route::patch('/keyauthorizations/{keyAuthorization}', [KeyAuthorizationController::class, 'update'])
        ->name('keyauthorizations.update')
        ->middleware('permission:keyauthorizations.edit');

    Route::post('/coordinatorkeys/add-authorization', [KeyAuthorizationController::class, 'addAuthorization'])
        ->name('coordinatorkeys.add-authorization')
        ->middleware('permission:keyauthorizations.create');

    Route::delete('/coordinatorkeys/remove-authorization/{authorization}', [KeyAuthorizationController::class, 'removeAuthorization'])
        ->name('coordinatorkeys.remove-authorization')
        ->middleware('permission:keyauthorizations.edit');
});
