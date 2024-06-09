<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebBookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = [
            'Fiksi',
            'Non-fiksi',
            'Novel',
            'Cerpen',
            'Drama',
            'Puisi',
            'Biografi',
            'Sejarah',
            'Ilmiah',
            'Teknologi',
            'Bisnis',
            'Kesehatan',
            'Seni',
            'Musik',
            'Pendidikan',
            'Agama',
            'Filosofi',
            'Politik',
            'Psikologi',
            'Hukum',
            'Perjalanan',
            'Kuliner',
            'Olahraga',
            'Alam',
            'Petualangan',
        ];

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'kategori' => 'required',
            'total_stock' => 'required|integer',
            'deskripsi' => 'required',
            'ratings' => 'nullable|numeric|min:0|max:10',
            'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $book = new Book();
        $book->judul = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->penerbit = $request->penerbit;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->kategori = $request->kategori;
        $book->total_stock = $request->total_stock;
        $book->stock_available = $request->total_stock; 
        $book->deskripsi = $request->deskripsi;
        $book->ratings = $request->ratings;

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $fileName); 
            $book->cover = 'covers/' . $fileName; 
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show($id)
    {
        $book = Book::find($id);
        if ($book) {
            // Check if cover image exists
            if ($book->cover) {
                // Generate full URL for the cover image
                $book->cover = asset('storage/' . $book->cover);
            }
            return view('books.show', compact('book'));
        } else {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }
    }

    public function edit($id)
    {
        $book = Book::find($id);
        if ($book) {
            return view('books.edit', compact('book'));
        } else {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'kategori' => 'required',
            'total_stock' => 'required|integer',
            'deskripsi' => 'required',
            'ratings' => 'nullable|numeric|min:0|max:10',
            'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $book = Book::find($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        $book->judul = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->penerbit = $request->penerbit;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->kategori = $request->kategori;
        $book->total_stock = $request->total_stock;
        $book->stock_available = $request->total_stock - $book->loans()->where('status', 'Dipinjam')->count(); // Adjust stock available
        $book->deskripsi = $request->deskripsi;
        $book->ratings = $request->ratings;

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $fileName); // Store file in storage directory
            // Hapus file cover lama jika ada
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }
            $book->cover = 'covers/' . $fileName;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Hapus file cover jika ada sebelum menghapus buku
        if ($book->cover) {
            Storage::delete('public/' . $book->cover);
        }
        $book->delete();
        
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

}

