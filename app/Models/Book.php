<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'kategori',
        'total_stock', 'stock_available', 'deskripsi', 'ratings', 'cover', 'artikel'
    ];

    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function calculateAverageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
