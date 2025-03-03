<?php

use App\Http\Controllers\Api\CoordinatorKeysController;
use App\Http\Controllers\Api\KeyAuthorizationController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/helloworld', [UserController::class, 'helloworld']);
    Route::get('/user/{id}/keys', [KeyAuthorizationController::class, 'getUserKeys']);
    Route::get('/user/{id}/loans/active', [LoanController::class, 'getUserActiveLoans']);
    Route::get('/user/{id}/coordinator-keys', [CoordinatorKeysController::class, 'getCoordinatorKeys']);
    Route::get('/coordinator/{id}/loans/active', [LoanController::class, 'getCoordinatorLoans']);
    Route::get('/coordinator/{userId}/key/{keyId}/laboratory-access', [CoordinatorKeysController::class, 'getLaboratoryAccess']);
    Route::get('/user/search', [CoordinatorKeysController::class, 'searchUsers']);
    Route::post('/key/authorize', [KeyAuthorizationController::class, 'addAuthorization']);
    Route::post('/key/revoke', [KeyAuthorizationController::class, 'removeAuthorization']);

});

