<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Middleware\PermissionMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::aliasMiddleware('permission', PermissionMiddleware::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index')
        ->middleware('permission:users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create')
        ->middleware('permission:users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store')
        ->middleware('permission:users.create');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show')
        ->middleware('permission:users.show');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit')
        ->middleware('permission:users.edit');

    Route::patch('/users/{user}', [UserController::class, 'update'])
        ->name('users.update')
        ->middleware('permission:users.edit');

    Route::get('/users/{user}/delete', [UserController::class, 'delete'])
        ->name('users.delete')
        ->middleware('permission:users.delete');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('permission:users.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/campi', [CampusController::class, 'index'])
        ->name('campi.index')
        ->middleware('permission:campi.index');

    Route::get('/campi/create', [CampusController::class, 'create'])
        ->name('campi.create')
        ->middleware('permission:campi.create');

    Route::post('/campi', [CampusController::class, 'store'])
        ->name('campi.store')
        ->middleware('permission:campi.create');

    Route::get('/campi/{campus}', [CampusController::class, 'show'])
        ->name('campi.show')
        ->middleware('permission:campi.show');

    Route::get('/campi/{campus}/edit', [CampusController::class, 'edit'])
        ->name('campi.edit')
        ->middleware('permission:campi.edit');

    Route::patch('/campi/{campus}', [CampusController::class, 'update'])
        ->name('campi.update')
        ->middleware('permission:campi.edit');

});


require __DIR__ . '/auth.php';
