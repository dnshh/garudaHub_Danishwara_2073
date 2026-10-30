<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:10,1')
        ->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1') // batasi 5 percobaan login per menit
        ->name('login.store');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/projects/{project}/bids', [BidController::class, 'store'])->name('projects.bids.store');
    Route::post('/projects/{project}/bids/{bid}/pick', [BidController::class, 'pick'])->name('projects.bids.pick');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');
});

Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
