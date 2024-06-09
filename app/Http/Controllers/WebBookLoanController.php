<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebHomeController extends Controller
{
    public function index()
    {
        // Ambil total buku bulan ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalBooksCurrentMonth = Book::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Ambil total buku bulan lalu
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastMonthYear = Carbon::now()->subMonth()->year;
        $totalBooksLastMonth = Book::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();

        // Hitung total semua buku
        $totalBooks = Book::count();

        // Hitung persentase perubahan buku
        if ($totalBooksLastMonth == 0) {
            $percentageChangeBooks = $totalBooksCurrentMonth * 100; // Jika bulan lalu tidak ada buku, anggap 100% perubahan
        } else {
            $percentageChangeBooks = (($totalBooksCurrentMonth - $totalBooksLastMonth) / $totalBooksLastMonth) * 100;
        }

        // Ambil total user bulan ini
        $totalUsersCurrentMonth = User::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Ambil total user bulan lalu
        $totalUsersLastMonth = User::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();

        // Hitung total semua user
        $totalUsers = User::count();

        // Hitung persentase perubahan user
        if ($totalUsersLastMonth == 0) {
            $percentageChangeUsers = $totalUsersCurrentMonth * 100; // Jika bulan lalu tidak ada user, anggap 100% perubahan
        } else {
            $percentageChangeUsers = (($totalUsersCurrentMonth - $totalUsersLastMonth) / $totalUsersLastMonth) * 100;
        }

        // Ambil total peminjaman buku bulan ini
        $totalLoansCurrentMonth = BookLoan::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Ambil total peminjaman buku bulan lalu
        $totalLoansLastMonth = BookLoan::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();

        // Hitung total semua peminjaman buku
        $totalLoans = BookLoan::count();

        // Hitung persentase perubahan peminjaman
        if ($totalLoansLastMonth == 0) {
            $percentageChangeLoans = $totalLoansCurrentMonth * 100; // Jika bulan lalu tidak ada peminjaman, anggap 100% perubahan
        } else {
            $percentageChangeLoans = (($totalLoansCurrentMonth - $totalLoansLastMonth) / $totalLoansLastMonth) * 100;
        }

        // Ambil buku yang tersedia (belum dipinjam)
        $availableBooks = Book::where('stock_available', '>', 0)->count();

        // Ambil 8 peminjaman terbaru
        $latestBookLoans = BookLoan::with('book', 'user')->orderBy('created_at', 'desc')->take(8)->get();

        // Ambil 8 buku yang paling banyak dipinjam
        $mostBorrowedBooks = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->take(8)
            ->get();

        // Kirim data ke view
        return view('home', compact(
            'totalBooks',
            'totalBooksCurrentMonth',
            'totalBooksLastMonth',
            'percentageChangeBooks',
            'totalUsers',
            'totalUsersCurrentMonth',
            'totalUsersLastMonth',
            'percentageChangeUsers',
            'totalLoans',
            'totalLoansCurrentMonth',
            'totalLoansLastMonth',
            'percentageChangeLoans',
            'availableBooks',
            'latestBookLoans',
            'mostBorrowedBooks'
        ));
    }
}
