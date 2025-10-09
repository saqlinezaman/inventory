<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('Home');
// About route
Route::get('/about', [HomeController::class, 'about'])->name('About');

// Auth
Route::post('/user-registration',[UserController::class, 'userRegistration'])->name('user.registration');
Route::post('/user-login',[UserController::class, 'userLogin'])->name('user.login');

// Dashboard route with middleware
Route::middleware(TokenVerificationMiddleware::class)->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('Dashboard');
});