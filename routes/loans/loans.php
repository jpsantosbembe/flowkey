<?php

use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/loans', [LoanController::class, 'index'])
    ->name('loans.index')
    ->middleware('permission:loans.index');

    Route::get('/loans/create', [LoanController::class, 'create'])
    ->name('loans.create')
    ->middleware('permission:loans.create');

    Route::post('/loans', [LoanController::class, 'store'])
    ->name('loans.store')
    ->middleware('permission:loans.create');

    Route::get('/loans/{loan}', [LoanController::class, 'show'])
    ->name('loans.show')
    ->middleware('permission:loans.show');

    Route::get('/loans/{loan}/edit', [LoanController::class, 'edit'])
    ->name('loans.edit')
    ->middleware('permission:loans.edit');

    Route::patch('/loans/{loan}', [LoanController::class, 'update'])
    ->name('loans.update')
    ->middleware('permission:loans.edit');

    Route::get('/history', [LoanController::class, 'history'])
        ->name('loans.history')
        ->middleware('permission:loans.index');
});
