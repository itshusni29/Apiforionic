<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
                'artikel' => 'nullable|file|mimes:pdf|max:15360', // max 15MB for PDF files
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $book = new Book();
        $book->judul = $validated['judul'];
        $book->pengarang = $validated['pengarang'];
        $book->penerbit = $validated['penerbit'];
        $book->tahun_terbit = $validated['tahun_terbit'];
        $book->kategori = $validated['kategori'];
        $book->total_stock = $validated['total_stock'];
        $book->stock_available = $validated['total_stock'];
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
        $book = Book::find($id);
        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }
    
        // Validasi data yang diperbarui
        $validated = $request->validate([
            'judul' => 'nullable',
            'pengarang' => 'nullable',
            'penerbit' => 'nullable',
            'tahun_terbit' => 'nullable|date',
            'kategori' => ['nullable', function ($attribute, $value, $fail) {
                $categories = [
                    'Fiksi', 'Non-fiksi', 'Novel', 'Cerpen', 'Drama', 'Puisi', 'Biografi', 'Sejarah', 'Ilmiah', 'Teknologi', 'Bisnis', 'Kesehatan', 'Seni', 'Musik', 'Pendidikan', 'Agama', 'Filosofi', 'Politik', 'Psikologi', 'Hukum', 'Perjalanan', 'Kuliner', 'Olahraga', 'Alam', 'Petualangan',
                ];
                if (!in_array($value, $categories)) {
                    $fail('Invalid category selected.');
                }
            }],
            'total_stock' => 'nullable|integer',
            'deskripsi' => 'nullable',
            'ratings' => 'nullable|numeric|min:0|max:10',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'artikel' => 'nullable|file|mimes:pdf|max:15360', // max 15MB for PDF files
        ]);
    
        // Simpan data yang diperbarui
        if (isset($validated['judul'])) {
            $book->judul = $validated['judul'];
        }
        if (isset($validated['pengarang'])) {
            $book->pengarang = $validated['pengarang'];
        }
        if (isset($validated['penerbit'])) {
            $book->penerbit = $validated['penerbit'];
        }
        if (isset($validated['tahun_terbit'])) {
            $book->tahun_terbit = $validated['tahun_terbit'];
        }
        if (isset($validated['kategori'])) {
            $book->kategori = $validated['kategori'];
        }
        if (isset($validated['total_stock'])) {
            $book->total_stock = $validated['total_stock'];
            $book->stock_available = $validated['total_stock'] - $book->loans()->where('status', 'Dipinjam')->count(); // Adjust stock available
        }
        if (isset($validated['deskripsi'])) {
            $book->deskripsi = $validated['deskripsi'];
        }
        if (isset($validated['ratings'])) {
            $book->ratings = $validated['ratings'];
        }
    
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
