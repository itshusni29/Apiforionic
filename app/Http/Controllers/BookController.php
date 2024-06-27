<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    // Validation rules method
    protected function validationRules($isUpdate = false)
    {
        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|date',
            'kategori' => 'required',
            'total_stock' => 'required|integer',
            'deskripsi' => 'required',
            'ratings' => 'nullable|numeric|min:0|max:10',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB for images
            'artikel' => 'nullable|file|mimes:pdf|max:15360', // max 15MB for PDF files
        ];

        if ($isUpdate) {
            $rules = array_map(function ($rule) {
                return str_replace('required', 'nullable', $rule);
            }, $rules);
        }

        return $rules;
    }

    // Handle file upload for cover and artikel
    protected function handleFileUpload(Request $request, Book $book)
    {
        // Handle artikel file upload
        if ($request->hasFile('artikel')) {
            if ($book->artikel) {
                Storage::delete('public/' . $book->artikel);
            }
            $artikelFile = $request->file('artikel');
            $artikelFileName = time() . '_artikel.' . $artikelFile->getClientOriginalExtension();
            $artikelFile->storeAs('public/artikels', $artikelFileName);
            $book->artikel = 'artikels/' . $artikelFileName;
        }

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }
            $coverFile = $request->file('cover');
            $coverFileName = time() . '_cover.' . $coverFile->getClientOriginalExtension();
            $coverFile->storeAs('public/covers', $coverFileName);
            $book->cover = 'covers/' . $coverFileName;
        }
    }

    // Index method for fetching books with filters
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('category')) {
            $query->where('kategori', $request->input('category'));
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('pengarang', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('new')) {
            $query->orderBy('created_at', 'desc');
        }

        $books = $query->get();

        foreach ($books as $book) {
            if ($book->cover) {
                $book->cover = asset('storage/' . $book->cover);
            }
            if ($book->artikel) {
                $book->artikel = asset('storage/' . $book->artikel);
            }
        }

        return response()->json($books);
    }

    // Store method for creating a new book
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

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

        $this->handleFileUpload($request, $book);

        $book->save();

        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    // Show method to fetch a single book by ID
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->cover) {
            $book->cover = asset('storage/' . $book->cover);
        }

        if ($book->artikel) {
            $book->artikel = asset('storage/' . $book->artikel);
        }

        return response()->json($book);
    }

    // Update method to update an existing book
    public function update(Request $request, $id)
    {
        $validated = $request->validate($this->validationRules(true));

        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Only update the fields that are present in the request
        $book->fill(array_filter($validated));

        if (isset($validated['total_stock'])) {
            $book->stock_available = $validated['total_stock'] - $book->loans()->where('status', 'Dipinjam')->count();
        }

        $this->handleFileUpload($request, $book);

        $book->save();

        return response()->json(['message' => 'Book updated successfully', 'book' => $book], 200);
    }

    // Delete method to delete a book by ID
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Delete cover file if exists before deleting the book
        if ($book->cover) {
            Storage::delete('public/' . $book->cover);
        }

        // Delete artikel file if exists before deleting the book
        if ($book->artikel) {
            Storage::delete('public/' . $book->artikel);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }

    // Search method to search books based on a query parameter
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['message' => 'Query parameter is required'], 400);
        }

        $books = Book::where('judul', 'like', '%' . $query . '%')
            ->orWhere('pengarang', 'like', '%' . $query . '%')
            ->orWhere('penerbit', 'like', '%' . $query . '%')
            ->get();

        foreach ($books as $book) {
            if ($book->cover) {
                $book->cover = asset('storage/' . $book->cover);
            }
            if ($book->artikel) {
                $book->artikel = asset('storage/' . $book->artikel);
            }
        }

        return response()->json($books);
    }

    // Method to fetch and return PDF file content
    public function getPdf(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Ensure artikel (PDF file) exists for the book
        if (!$book->artikel) {
            return response()->json(['message' => 'PDF file not found for this book'], 404);
        }

        // Get the storage path for the artikel file
        $artikelPath = storage_path('app/public/' . $book->artikel);

        // Check if the file exists
        if (!file_exists($artikelPath)) {
            return response()->json(['message' => 'PDF file not found in storage'], 404);
        }

        // Return the PDF file content
        return response()->file($artikelPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($artikelPath) . '"'
        ]);
    }

}
