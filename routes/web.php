<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\CoordinatorKeysController;
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


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'      => Route::has('login'),
        'canRegister'   => Route::has('register'),
        'laravelVersion'=> Application::VERSION,
        'phpVersion'    => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'permissions' => auth()->user()->getAllPermissions()->pluck('name'),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Removida a rota DELETE para Profile, pois não queremos destroy/delete.
});

Route::aliasMiddleware('permission', PermissionMiddleware::class);

Route::middleware(['auth'])->group(function () {
    // Guardhouses

    // Keys

    // Key Authorizations

    // Coordinator Keys
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

    // Loans
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

    // Rota para API de Keys
    Route::get('api/keys')->name('api.keys')->uses(KeyController::class . '@indexApi');
});

require __DIR__ . '/auth.php';
