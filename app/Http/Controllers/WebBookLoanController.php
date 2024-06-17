<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookLoan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebBookLoanController extends Controller
{
    public function borrowForm(Request $request)
    {
        $users = User::all();
        $categories = [
            'Fiksi', 'Non-fiksi', 'Novel', 'Cerpen', 'Drama', 'Puisi', 'Biografi', 'Sejarah', 'Ilmiah', 'Teknologi', 
            'Bisnis', 'Kesehatan', 'Seni', 'Musik', 'Pendidikan', 'Agama', 'Filosofi', 'Politik', 'Psikologi', 
            'Hukum', 'Perjalanan', 'Kuliner', 'Olahraga', 'Alam', 'Petualangan'
        ];

        $query = Book::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('kategori', $request->category);
        }

        $books = $query->get();

        return view('borrow_books.form', compact('users', 'categories', 'books'));
    }

    public function borrow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'selected_books' => 'required|array|min:1', // Ubah 'book_id' menjadi 'selected_books' sesuai dengan form
            'selected_books.*' => 'exists:books,id', // Validasi setiap buku yang dipilih
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = User::findOrFail($request->user_id);
        $selectedBooks = $request->selected_books; // Ambil semua buku yang dipilih dari form
    
        foreach ($selectedBooks as $bookId) {
            // Periksa jika buku sudah dipinjam
            if (BookLoan::where('user_id', $user->id)->where('book_id', $bookId)->where('status', 'Dipinjam')->exists()) {
                return redirect()->back()->with('error', 'You have already borrowed one or more of the selected books.');
            }
    
            // Cek ketersediaan buku
            $book = Book::findOrFail($bookId);
            if ($book->stock_available <= 0) {
                return redirect()->back()->with('error', 'One or more of the selected books are currently not available.');
            }
    
            // Membuat data peminjaman
            $bookLoan = new BookLoan();
            $bookLoan->user_id = $user->id;
            $bookLoan->book_id = $bookId;
            $bookLoan->tanggal_peminjaman = now();
            $bookLoan->status = 'Dipinjam';
            $bookLoan->save();
    
            // Kurangi stok yang tersedia
            $book->stock_available--;
            $book->save();
        }
    
        return redirect()->back()->with('success', 'Books borrowed successfully.');
    }
    
    public function returnBook(Request $request, $loanId)
    {
        $bookLoan = BookLoan::findOrFail($loanId);
    
        // Check if the loan belongs to the user and status is 'Dipinjam'
        if ($bookLoan->user_id !== Auth::id() || $bookLoan->status !== 'Dipinjam') {
            return redirect()->back()->with('error', 'Unauthorized or book already returned.');
        }
    
        // Mark the book as returned only if status is 'Dipinjam'
        if ($bookLoan->status === 'Dipinjam') {
            // Mark the book as returned
            $bookLoan->status = 'Dikembalikan';
            $bookLoan->tanggal_pengembalian_aktual = now();
            $bookLoan->save();
    
            // Increase the available stock
            $book = Book::findOrFail($bookLoan->book_id);
            $book->stock_available++;
            $book->save();
    
            return redirect()->back()->with('success', 'Book returned successfully.');
        } else {
            return redirect()->back()->with('error', 'Book already returned.');
        }
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

    public function borrowedBooksByBook()
    {
        
        $borrowedBooks = BookLoan::where('status', 'Dipinjam')
                                ->with('book', 'user') // Mengambil relasi buku dan user
                                ->get();
    
        return view('borrow_books.borrowed_books_by_book', compact('borrowedBooks'));
    }
    
}
