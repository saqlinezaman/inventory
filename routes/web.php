<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('Home');
// About route
Route::get('/about', [HomeController::class, 'about'])->name('About');

// Auth --------------------------------------------------------------------------------- ------------------------------------------------------------------------------------------

// register------------------------------------
Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user.registration');
// login---------------------------------------
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user.login');
// send otp---------------------------------------
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('send.otp');
// verify otp ---------------------------------------
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');

// Dashboard route with middleware ------------------------------------------------- -----------------------------------------------------------------------------------------
Route::middleware(TokenVerificationMiddleware::class)->group(function () {

    // reset password-------------------------------
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
    // dashboard------------------------------------
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('Dashboard');
    // logout---------------------------------------
    Route::get('/logout', [UserController::class, 'logout'])->name('Logout');

    // all Category routes  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    
    // create----------------------------------------
    Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('Category.create');
    // List------------------------------------------
    Route::get('/list-category', [CategoryController::class, 'listCategory'])->name('Category.list');
    // category by id----------------------------------
    Route::post('/category-by-id', [CategoryController::class, 'categoryById']);
    // update------------------------------------------
    Route::post('/update-category', [CategoryController::class, 'categoryUpdate'])->name('Category.update');
    // delete------------------------------------------
    Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('Category.delete');

    //all product routs ----------------------------------------------------------------- -------------------------------------------------------------------------------------
    // create product ----------------------------------------
    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('Product.create');
    // list product ------------------------------------------
    Route::get('/list-product', [ProductController::class, 'listProduct'])->name('Product.list');
    // product by id------------------------------------------
    Route::post('/product-by-id', [ProductController::class, 'productById']);
    // update------------------------------------------
    Route::post('/update-product', [ProductController::class, 'productUpdate'])->name('Product.update');
    // delete------------------------------------------
    Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('Product.delete');
});
