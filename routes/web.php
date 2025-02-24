<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\CoordinatorKeysController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuardhouseController;
use App\Http\Controllers\KeyAuthorizationController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Middleware\PermissionMiddleware;

require __DIR__ . '/users/users.php';
require __DIR__ . '/campus/campus.php';
require __DIR__ . '/guardhouses/guardhouses.php';
require __DIR__ . '/keys/keys.php';
require __DIR__ . '/keyauthorizations/keyauthorizations.php';
require __DIR__ . '/coordinatorkeys/coordinatorkeys.php';
require __DIR__ . '/loans/loans.php';

Route::aliasMiddleware('permission', PermissionMiddleware::class);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'      => Route::has('login'),
        'canRegister'   => Route::has('register'),
        'laravelVersion'=> Application::VERSION,
        'phpVersion'    => PHP_VERSION,
    ]);
});

//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard2', [
//        'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
//    ]);
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Removida a rota DELETE para Profile, pois não queremos destroy/delete.
});

Route::middleware(['auth'])->group(function () {

    // Rota para API de Keys
    Route::get('api/keys')->name('api.keys')->uses(KeyController::class . '@indexApi');
});

require __DIR__ . '/auth.php';
