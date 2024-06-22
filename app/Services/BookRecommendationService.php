<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Wishlist;
use Illuminate\Support\Collection;

class BookRecommendationService
{
    public function recommendBooks($userId)
    {
        // Ambil daftar buku dari wishlist pengguna
        $userWishlist = $this->getUserWishlist($userId);

        // Ambil daftar buku yang pernah dipinjam oleh pengguna
        $userBorrowedBooks = $this->getUserBorrowedBooks($userId);

        // Gabungkan wishlist dan buku yang pernah dipinjam
        $combinedBooks = $userWishlist->merge($userBorrowedBooks);

        // Ambil kategori yang paling sering muncul dari buku yang pernah dipinjam dan diinginkan
        $mostFrequentCategory = $this->getMostFrequentCategory($combinedBooks);

        // Ambil buku-buku yang paling sering dipinjam dalam kategori yang sama
        $recommendedBooks = $this->getRecommendedBooks($mostFrequentCategory, $userId);

        // Saring buku yang sudah ada di wishlist atau pernah dipinjam
        $recommendedBooks = $this->filterBooksAlreadyInWishlistOrBorrowed($recommendedBooks, $combinedBooks);

        return $recommendedBooks;
    }

    protected function getUserWishlist($userId)
    {
        return Wishlist::where('user_id', $userId)->pluck('book_id');
    }

    protected function getUserBorrowedBooks($userId)
    {
        return BookLoan::where('user_id', $userId)->where('status', 'Dipinjam')->pluck('book_id');
    }

    protected function getMostFrequentCategory($books)
    {
        // Menghitung frekuensi setiap kategori dalam koleksi buku
        $categoryCounts = $books->map(function ($bookId) {
            $book = Book::find($bookId);
            if ($book) {
                return $book->kategori;
            }
        })->countBy();

        // Mengambil kategori dengan frekuensi tertinggi
        $mostFrequentCategory = $categoryCounts->sortDesc()->keys()->first();

        return $mostFrequentCategory;
    }

    protected function getRecommendedBooks($category, $userId)
    {
        // Ambil buku-buku dalam kategori yang sama, kecuali yang sudah dipinjam atau diinginkan oleh user
        return Book::where('kategori', $category)
                   ->whereNotIn('id', $this->getUserWishlist($userId)->merge($this->getUserBorrowedBooks($userId))->toArray())
                   ->get();
    }

    protected function filterBooksAlreadyInWishlistOrBorrowed($recommendedBooks, $combinedBooks)
    {
        // Memfilter buku yang sudah ada di wishlist atau pernah dipinjam
        return $recommendedBooks->reject(function ($book) use ($combinedBooks) {
            return $combinedBooks->contains($book->id);
        });
    }
}
