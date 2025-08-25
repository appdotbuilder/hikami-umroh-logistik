<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JamaahController;
use Illuminate\Support\Facades\Route;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page - shows system overview
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - role-based user dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User management (Authorization handled in controller)
    Route::resource('users', UserController::class);
    
    // Jamaah management (Authorization handled in controller)
    Route::resource('jamaah', JamaahController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
