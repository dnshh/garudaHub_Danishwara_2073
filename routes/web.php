<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1') // batasi 5 percobaan login per menit
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/projects/create', fn () => 'Segera hadir')->middleware('auth')->name('projects.create');
Route::get('/dashboard', fn () => 'Segera hadir')->middleware('auth')->name('dashboard');
Route::get('/admin', fn () => 'Segera hadir')->middleware('auth')->name('admin.index');
Route::post('/projects/{project}/bids', fn () => abort(501))->middleware('auth')->name('projects.bids.store');
Route::post('/projects/{project}/bids/{bid}/pick', fn () => abort(501))->middleware('auth')->name('projects.bids.pick');

Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
