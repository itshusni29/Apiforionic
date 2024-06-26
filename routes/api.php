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

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh'])->middleware('jwt.refresh');
Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

// Protected routes
Route::middleware(['jwt.auth'])->group(function () {
    // User routes
    Route::apiResource('users', UserController::class)->except(['edit']);
    
    // User resource routes (for viewing users)
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

        // Get authenticated user
        Route::get('/user', function () {
            return auth()->user();
        });

    // Admin routes (assume 'admin' middleware is implemented separately)
    Route::middleware(['admin'])->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{book}', [BookController::class, 'update']);
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
    });

    // Book routes
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/search', [BookController::class, 'search']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::get('/books/{book}/pdf', [BookController::class, 'getPdf']);

    // Book loan routes
    Route::get('/borrowed-books', [BookLoanController::class, 'index']);
    Route::post('/borrow/{bookId}', [BookLoanController::class, 'borrow']);
    Route::post('/return/{loanId}', [BookLoanController::class, 'returnBook']);
    Route::get('/borrowed-books/user', [BookLoanController::class, 'borrowedBooksByUser']);

    // Wishlist routes
    Route::apiResource('wishlists', WishlistController::class)->only(['index', 'store', 'destroy']);
    
    // Book loan history route
    Route::get('/loan-history', [BookLoanHistoryController::class, 'index']);

    // Book rating routes
    Route::apiResource('ratings', RatingsController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // Book recommendation route
    Route::get('/recommendations/{userId}', [BookRecommendationController::class, 'recommend']);


    
});

// Default fallback for undefined routes
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
