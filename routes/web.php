<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\CoordinatorKeysController;
use App\Http\Controllers\GuardhouseController;
use App\Http\Controllers\KeyAuthorizationController;
use App\Http\Controllers\KeyController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/guardhouses', [GuardhouseController::class, 'index'])
        ->name('guardhouses.index')
        ->middleware('permission:guardhouses.index');

    Route::get('/guardhouses/create', [GuardhouseController::class, 'create'])
        ->name('guardhouses.create')
        ->middleware('permission:guardhouses.create');

    Route::post('/guardhouses', [GuardhouseController::class, 'store'])
        ->name('guardhouses.store')
        ->middleware('permission:guardhouses.create');

    Route::get('/guardhouses/{guardhouse}', [GuardhouseController::class, 'show'])
        ->name('guardhouses.show')
        ->middleware('permission:guardhouses.show');

    Route::get('/guardhouses/{guardhouse}/edit', [GuardhouseController::class, 'edit'])
        ->name('guardhouses.edit')
        ->middleware('permission:guardhouses.edit');

    Route::patch('/guardhouses/{guardhouse}', [GuardhouseController::class, 'update'])
        ->name('guardhouses.update')
        ->middleware('permission:guardhouses.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/keys', [KeyController::class, 'index'])
        ->name('keys.index')
        ->middleware('permission:keys.index');

    Route::get('/keys/create', [KeyController::class, 'create'])
        ->name('keys.create')
        ->middleware('permission:keys.create');

    Route::post('/keys', [KeyController::class, 'store'])
        ->name('keys.store')
        ->middleware('permission:keys.create');

    Route::get('/keys/{key}', [KeyController::class, 'show'])
        ->name('keys.show')
        ->middleware('permission:keys.show');

    Route::get('/keys/{key}/edit', [KeyController::class, 'edit'])
        ->name('keys.edit')
        ->middleware('permission:keys.edit');

    Route::patch('/keys/{key}', [KeyController::class, 'update'])
        ->name('keys.update')
        ->middleware('permission:keys.edit');
});

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
        ->name('keyauthorizations.edit')
        ->middleware('permission:keyauthorizations.edit');
});

Route::middleware(['auth'])->group(function (){
    Route::get('/coordinatorkeys', [CoordinatorKeysController::class, 'index'])
        ->name('coordinatorkeys.index')
        ->middleware('permission:coordinatorkeys.index');

    Route::get('/coordinatorkeys/create', [CoordinatorKeysController::class, 'create'])
        ->name('coordinatorkeys.create')
        ->middleware('permission:coordinatorkeys.create');

    Route::post('/coordinatorkeys', [CoordinatorKeysController::class, 'store'])
        ->name('coordinatorkeys.store')
        ->middleware('permission:coordinatorkeys.create');

    Route::get('/coordinatorkeys/{id}', [CoordinatorKeysController::class, 'show'])
        ->name('coordinatorkeys.show')
        ->middleware('permission:coordinatorkeys.show');

    Route::get('/coordinatorkeys/edit', [CoordinatorKeysController::class, 'edit'])
        ->name('coordinatorkeys.edit')
        ->middleware('permission:coordinatorkeys.edit');

    Route::get('coordinators/{id}', [CoordinatorKeysController::class, 'update'])
        ->name('coordinatorkeys.update')
        ->middleware('permission:coordinatorkeys.update');
});


require __DIR__ . '/auth.php';
