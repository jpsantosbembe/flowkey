<?php

use App\Http\Controllers\Api\UserController;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/helloworld', [UserController::class, 'helloworld']);
});
