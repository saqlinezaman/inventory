<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('Home');
// About route
Route::get('/about', [HomeController::class, 'about'])->name('About');
