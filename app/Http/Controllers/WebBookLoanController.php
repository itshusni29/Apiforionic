<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookLoan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WebBookLoanController extends Controller
{


    public function borrowForm()
    {
        $users = User::all();
        $books = Book::all();

        return view('borrow_books.form', compact('users', 'books'));
    }

    public function borrow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($request->user_id);
        $book = Book::findOrFail($request->book_id);

        // Check if user already borrowed this book
        if (BookLoan::where('user_id', $user->id)->where('book_id', $request->book_id)->where('status', 'Dipinjam')->exists()) {
            return redirect()->back()->with('error', 'You have already borrowed this book');
        }

        // Check if the book is available
        if ($book->stock_available <= 0) {
            return redirect()->back()->with('error', 'This book is currently not available');
        }

        // Create the loan
        $bookLoan = new BookLoan();
        $bookLoan->user_id = $user->id;
        $bookLoan->book_id = $request->book_id;
        $bookLoan->tanggal_peminjaman = now();
        $bookLoan->status = 'Dipinjam';
        $bookLoan->save();

        // Decrease the available stock
        $book->stock_available--;
        $book->save();

        return redirect()->back()->with('success', 'Book borrowed successfully');
    }

    public function returnBook(Request $request, $loanId)
    {
        $bookLoan = BookLoan::findOrFail($loanId);

        // Check if the loan belongs to the user
        if ($bookLoan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Mark the book as returned
        $bookLoan->status = 'Dikembalikan';
        $bookLoan->tanggal_pengembalian_aktual = now();
        $bookLoan->save();

        // Increase the available stock
        $book = Book::findOrFail($bookLoan->book_id);
        $book->stock_available++;
        $book->save();

        return redirect()->back()->with('success', 'Book returned successfully');
    }

    
    public function borrowedBooksByUser($userId)
    {
        // Mengambil semua buku yang dipinjam oleh user tertentu
        $user = User::findOrFail($userId);
        $borrowedBooks = BookLoan::where('user_id', $userId)
                                ->where('status', 'Dipinjam')
                                ->with('book')
                                ->get();

        return view('borrow_books.borrowed_books_by_user', compact('user', 'borrowedBooks'));
    }


    public function borrowedBooksByAllUsers()
    {
        // Mengambil semua user yang sedang meminjam buku
        $usersWithLoans = User::whereHas('bookLoans', function ($query) {
            $query->where('status', 'Dipinjam');
        })->get();
        
        return view('borrow_books.active_loans', compact('usersWithLoans'));
    }



    
}
