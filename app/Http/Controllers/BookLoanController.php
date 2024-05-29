<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Support\Facades\Auth;

class BookLoanController extends Controller
{
    public function borrow(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // Check if user already borrowed this book
        if (BookLoan::where('user_id', $user->id)->where('book_id', $bookId)->where('status', 'Dipinjam')->exists()) {
            return response()->json(['message' => 'You have already borrowed this book'], 400);
        }

        // Check if the book is available
        if ($book->stock_available <= 0) {
            return response()->json(['message' => 'This book is currently not available'], 400);
        }

        // Create the loan
        $bookLoan = new BookLoan();
        $bookLoan->user_id = $user->id;
        $bookLoan->book_id = $bookId;
        $bookLoan->tanggal_peminjaman = now();
        $bookLoan->status = 'Dipinjam';
        $bookLoan->save();

        // Decrease the available stock
        $book->stock_available--;
        $book->save();

        return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

    public function returnBook(Request $request, $loanId)
    {
        $bookLoan = BookLoan::findOrFail($loanId);

        // Check if the loan belongs to the user
        if ($bookLoan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Mark the book as returned
        $bookLoan->status = 'Dikembalikan';
        $bookLoan->tanggal_pengembalian_aktual = now();
        $bookLoan->save();

        // Increase the available stock
        $book = Book::findOrFail($bookLoan->book_id);
        $book->stock_available++;
        $book->save();

        return response()->json(['message' => 'Book returned successfully'], 200);
    }
}
?>
