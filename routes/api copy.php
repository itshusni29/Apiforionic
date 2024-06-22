<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\BookRecommendationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BookLoanHistoryController;
use App\Http\Controllers\RatingsController;
use Illuminate\Support\Facades\Route;




// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh'])->middleware('jwt.refresh');
Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

// Protected routes
Route::middleware(['jwt.auth'])->group(function () {

    // Get authenticated user
    Route::get('/user', function () {
        return auth()->user();
    });

    // User resource routes (for viewing users)
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

    // Allow users to update their own profile
    Route::put('/users/{user}', [UserController::class, 'update']);

    // Admin-only routes
    Route::middleware(['admin'])->group(function () {

        // Admin routes for managing books
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
    });

    // Viewing and searching books (accessible to authenticated users)
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/search', [BookController::class, 'search']);
    Route::get('/books/{book}', [BookController::class, 'show']);

    // Book loan routes
    Route::post('/borrow/{bookId}', [BookLoanController::class, 'borrow']);
    Route::post('/return/{loanId}', [BookLoanController::class, 'returnBook']);
    Route::get('/borrowed-books', [BookLoanController::class, 'borrowedBooksByUser']); // Added route for borrowed books by user

    // Wishlist routes
    Route::apiResource('wishlists', WishlistController::class)->only(['index', 'store', 'destroy']);

    // Loan history routes
    Route::get('/loan-history', [BookLoanHistoryController::class, 'index']);

    // Ratings routes
    Route::apiResource('ratings', RatingsController::class);

    // Book recommendation route
    Route::get('/recommendations/{userId}', [BookRecommendationController::class, 'recommend']);

});
