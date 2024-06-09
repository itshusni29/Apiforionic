<?php

use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebHomeController;
use App\Http\Controllers\WebUserController;
use App\Http\Controllers\WebBookController;
use App\Http\Controllers\WebBookLoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebHomeController::class, 'index'])->name('home')->middleware('auth');


Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::get('/register', [WebAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [WebAuthController::class, 'register']);
// Route untuk logout
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');



Route::get('/users', [WebUserController::class, 'index'])->name('users.index');
Route::get('/users/create', [WebUserController::class, 'create'])->name('users.create');
Route::post('/users', [WebUserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [WebUserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [WebUserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [WebUserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [WebUserController::class, 'destroy'])->name('users.destroy');




// Rute untuk menampilkan daftar buku
Route::get('/books', [WebBookController::class, 'index'])->name('books.index');

// Rute untuk menampilkan form tambah buku
Route::get('/books/create', [WebBookController::class, 'create'])->name('books.create');

// Rute untuk menyimpan buku baru
Route::post('/books', [WebBookController::class, 'store'])->name('books.store');

// Rute untuk menampilkan detail buku
Route::get('/books/{id}', [WebBookController::class, 'show'])->name('books.show');

// Rute untuk menampilkan form edit buku
Route::get('/books/{id}/edit', [WebBookController::class, 'edit'])->name('books.edit');

// Rute untuk memperbarui buku yang ada
Route::put('/books/{id}', [WebBookController::class, 'update'])->name('books.update');

// Rute untuk menghapus buku
Route::delete('/books/{id}', [WebBookController::class, 'destroy'])->name('books.destroy');




// Route untuk menampilkan formulir peminjaman
Route::get('/borrow-form', [WebBookLoanController::class, 'borrowForm'])->name('borrow.form');

// Route untuk melakukan peminjaman buku
Route::post('/borrow', [WebBookLoanController::class, 'borrow'])->name('borrow.book');

// Route untuk mengembalikan buku
Route::post('/return/{loanId}', [WebBookLoanController::class, 'returnBook'])->name('return.book');

// Route untuk menampilkan buku yang dipinjam oleh user tertentu
Route::get('/borrowed-books/user/{userId}', [WebBookLoanController::class, 'borrowedBooksByUser'])->name('borrowed.books.user');

// Route untuk menampilkan semua buku yang dipinjam oleh semua user
Route::get('/borrowed-books', [WebBookLoanController::class, 'borrowedBooksByAllUsers'])->name('borrowed.books.all');

