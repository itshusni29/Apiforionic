<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Support\Collection;

class BookRecommendationService
{
    public function recommendBooks($userId)
    {
        // Ambil daftar buku dari wishlist pengguna
        $userWishlist = $this->getUserWishlist($userId);

        // Ambil kategori yang paling sering muncul di wishlist
        $mostFrequentCategory = $this->getMostFrequentCategory($userWishlist);

        // Ambil buku-buku yang paling sering dipinjam dalam kategori yang sama
        $recommendedBooks = $this->getRecommendedBooks($mostFrequentCategory);

        // Saring buku yang sudah ada di wishlist
        $recommendedBooks = $this->filterBooksAlreadyInWishlist($recommendedBooks, $userWishlist);

        return $recommendedBooks;
    }

    protected function getUserWishlist($userId)
    {
        return Wishlist::where('user_id', $userId)->pluck('book_id');
    }
    protected function getMostFrequentCategory($wishlist)
    {
        // Menghitung frekuensi setiap kategori dalam wishlist
        $categoryCounts = $wishlist->map(function ($bookId) {
            $book = Book::find($bookId);
            if ($book) {
                return $book->kategori;
            }
        })->countBy();
    
        // Mengambil kategori dengan frekuensi tertinggi
        $mostFrequentCategory = $categoryCounts->sortDesc()->keys()->first();
    
        return $mostFrequentCategory;
    }
    
    

    protected function getRecommendedBooks($category)
    {
        // Ambil buku-buku dalam kategori yang sama
        return Book::where('kategori', $category)->get();
    }

    protected function filterBooksAlreadyInWishlist($recommendedBooks, $wishlist)
    {
        // Memfilter buku yang sudah ada di wishlist
        return $recommendedBooks->reject(function ($book) use ($wishlist) {
            return $wishlist->contains($book->id);
        });
    }
}
