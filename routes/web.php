<?php

use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebHomeController;
use App\Http\Controllers\WebUserController;
use App\Http\Controllers\WebBookController;
use App\Http\Controllers\WebBookLoanController;
use Illuminate\Support\Facades\Route;

// Routes using web middleware
Route::get('/', [WebHomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::get('/register', [WebAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [WebAuthController::class, 'register']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::get('/users', [WebUserController::class, 'index'])->name('users.index');
Route::get('/users/create', [WebUserController::class, 'create'])->name('users.create');
Route::post('/users', [WebUserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [WebUserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [WebUserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [WebUserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [WebUserController::class, 'destroy'])->name('users.destroy');

Route::get('/books', [WebBookController::class, 'index'])->name('books.index');
Route::get('/books/create', [WebBookController::class, 'create'])->name('books.create');
Route::post('/books', [WebBookController::class, 'store'])->name('books.store');
Route::get('/books/{id}', [WebBookController::class, 'show'])->name('books.show');
Route::get('/books/{id}/edit', [WebBookController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', [WebBookController::class, 'update'])->name('books.update');
Route::delete('/books/{id}', [WebBookController::class, 'destroy'])->name('books.destroy');

Route::get('/borrow', [WebBookLoanController::class, 'borrowForm'])->name('borrow.form');
Route::post('/borrow', [WebBookLoanController::class, 'borrow'])->name('borrow.book');
Route::post('/return/{loanId}', [WebBookLoanController::class, 'returnBook'])->name('return.book');
Route::get('/borrowed-books/user/{userId}', [WebBookLoanController::class, 'borrowedBooksByUser'])->name('borrowed.books.user');
Route::get('/borrowed-books', [WebBookLoanController::class, 'borrowedBooksByAllUsers'])->name('borrowed.books.all');
Route::get('/borrowed-books/by-book', [WebBookLoanController::class, 'borrowedBooksByBook'])->name('borrowed.books.by.book');
