<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::resource('books', BookController::class);



// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // User resource routes
    Route::apiResource('users', UserController::class);

    // Get authenticated user
    Route::get('/user', function () {
        return auth()->user();
    });
});
