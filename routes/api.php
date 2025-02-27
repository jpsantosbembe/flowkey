<?php

use App\Http\Controllers\Api\KeyAuthorizationController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/helloworld', [UserController::class, 'helloworld']);
    Route::get('/user/{id}/keys', [KeyAuthorizationController::class, 'getUserKeys']);
    Route::get('/user/{id}/loans/active', [LoanController::class, 'getUserActiveLoans']);
});

