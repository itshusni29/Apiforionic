<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BookLoanHistoryController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']); // Add route for token refresh

// Protected routes
Route::middleware(['jwt.auth'])->group(function () {
    
    // User resource routes
    Route::apiResource('users', UserController::class);

    // Get authenticated user
    Route::get('/user', function () {
        return auth()->user();
    });
    
    // Book resource routes
    Route::apiResource('books', BookController::class);
    Route::post('/borrow/{bookId}', [BookLoanController::class, 'borrow']);
    Route::post('/return/{loanId}', [BookLoanController::class, 'returnBook']);
    // Wishlist routes
    Route::get('/wishlists', [WishlistController::class, 'index']);
    Route::post('/wishlists', [WishlistController::class, 'store']);
    Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy']);
    // Loan history routes
    Route::get('/loan-history', [BookLoanHistoryController::class, 'index']);

});

