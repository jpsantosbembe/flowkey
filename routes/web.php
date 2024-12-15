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


require __DIR__ . '/auth.php';
