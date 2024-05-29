<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'kategori',
        'total_stock', 'stock_available', 'deskripsi', 'ratings', 'cover'
    ];

    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }
}
?>
