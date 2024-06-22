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
            'Fiksi', 'Non-fiksi', 'Novel', 'Cerpen', 'Drama', 'Puisi', 'Biografi', 'Sejarah', 'Ilmiah', 'Teknologi', 'Bisnis', 'Kesehatan', 'Seni', 'Musik', 'Pendidikan', 'Agama', 'Filosofi', 'Politik', 'Psikologi', 'Hukum', 'Perjalanan', 'Kuliner', 'Olahraga', 'Alam', 'Petualangan',
        ];

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required|date',
                'kategori' => 'required',
                'total_stock' => 'required|integer',
                'deskripsi' => 'required',
                'ratings' => 'nullable|numeric|min:0|max:10',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
                'artikel' => 'nullable|file|mimes:pdf|max:2048', // max 2MB for PDF files
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors(['error' => 'Validation failed: ' . $e->getMessage()]);
        }

        $book = new Book();
        $book->judul = $validated['judul'];
        $book->pengarang = $validated['pengarang'];
        $book->penerbit = $validated['penerbit'];
        $book->tahun_terbit = $validated['tahun_terbit'];
        $book->kategori = $validated['kategori'];
        $book->total_stock = $validated['total_stock'];
        $book->stock_available = $validated['total_stock']; // Set initial available stock to total stock
        $book->deskripsi = $validated['deskripsi'];
        $book->ratings = $validated['ratings'];

        // Handle artikel file upload
        if ($request->hasFile('artikel')) {
            $artikelFile = $request->file('artikel');
            $artikelFileName = time() . '.' . $artikelFile->getClientOriginalExtension();
            $artikelFile->storeAs('public/artikels', $artikelFileName); // Store file in storage directory
            $book->artikel = 'artikels/' . $artikelFileName; // Store relative path to the PDF file
        }

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverFileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $coverFileName); // Store file in storage directory
            $book->cover = 'covers/' . $coverFileName; // Store relative path to the image
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show($id)
    {
        $book = Book::find($id);
        if ($book) {
            return view('books.show', compact('book'));
        } else {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }
    }

    public function edit($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        $categories = [
            'Fiksi', 'Non-fiksi', 'Novel', 'Cerpen', 'Drama', 'Puisi', 'Biografi', 'Sejarah', 'Ilmiah', 'Teknologi', 'Bisnis', 'Kesehatan', 'Seni', 'Musik', 'Pendidikan', 'Agama', 'Filosofi', 'Politik', 'Psikologi', 'Hukum', 'Perjalanan', 'Kuliner', 'Olahraga', 'Alam', 'Petualangan',
        ];

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'kategori' => 'required', // Kategori harus diisi
            'total_stock' => 'required|integer',
            'deskripsi' => 'required',
            'ratings' => 'nullable|numeric|min:0|max:10',
            'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'artikel' => 'nullable|file|mimes:pdf|max:2048', // max 2MB for PDF files
        ]);

        $book = Book::find($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Memeriksa apakah kategori yang diinputkan ada di dalam daftar kategori yang tersedia
        $categories = [
            'Fiksi', 'Non-fiksi', 'Novel', 'Cerpen', 'Drama', 'Puisi', 'Biografi', 'Sejarah', 'Ilmiah', 'Teknologi', 'Bisnis', 'Kesehatan', 'Seni', 'Musik', 'Pendidikan', 'Agama', 'Filosofi', 'Politik', 'Psikologi', 'Hukum', 'Perjalanan', 'Kuliner', 'Olahraga', 'Alam', 'Petualangan',
        ];

        if (!in_array($request->kategori, $categories)) {
            return redirect()->back()->withErrors(['kategori' => 'Invalid category selected.']);
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

        // Handle artikel file upload
        if ($request->hasFile('artikel')) {
            // Hapus file artikel lama jika ada
            if ($book->artikel) {
                Storage::delete('public/' . $book->artikel);
            }
            $artikelFile = $request->file('artikel');
            $artikelFileName = time() . '.' . $artikelFile->getClientOriginalExtension();
            $artikelFile->storeAs('public/artikels', $artikelFileName); // Store file in storage directory
            $book->artikel = 'artikels/' . $artikelFileName; // Store relative path to the PDF file
        }

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            // Hapus file cover lama jika ada
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }
            $cover = $request->file('cover');
            $coverFileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $coverFileName); // Store file in storage directory
            $book->cover = 'covers/' . $coverFileName; // Store relative path to the image
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
        // Hapus file artikel jika ada sebelum menghapus buku
        if ($book->artikel) {
            Storage::delete('public/' . $book->artikel);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
