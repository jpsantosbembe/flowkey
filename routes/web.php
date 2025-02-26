<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\CoordinatorKeysController;
use App\Http\Controllers\ControlPanel;
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
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('controlpanel');
        }
        elseif ($user->hasRole('Coordenador')) {
            return redirect()->route('coordinatorkeys.mykeys');
        }
        elseif ($user->hasRole('Discente')) {
            return redirect()->route('appdownload');
        }
    }

    return Inertia::render('Auth/Login', [
        'canLogin'      => Route::has('login'),
        'canRegister'   => Route::has('register'),
        'laravelVersion'=> Application::VERSION,
        'phpVersion'    => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/controlpanel', [ControlPanel::class, 'index'])->name('controlpanel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
