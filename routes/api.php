<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\Application;
use \App\Http\Controllers\API\Auth as AuthControllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Routes group
Route::prefix('auth')->group(function () {
    // Login Route with get or post
    Route::post('login', AuthControllers\LoginController::class)->name('login');

    // Register Route
    Route::post('register', AuthControllers\RegisterController::class)->name('register');
    // Logout Route
    Route::delete('logout', AuthControllers\LogOutController::class)->middleware('auth:sanctum')->name('logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('requests')->group(function () {
        Route::post('/', Application\StoreController::class)->middleware('user')->name('requests.store');
    });
});

