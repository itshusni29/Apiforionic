<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
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
        }

        return response()->json($books);
    }

    // Store method for creating a new book
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
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
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
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->judul = $validated['judul'];
        $book->pengarang = $validated['pengarang'];
        $book->penerbit = $validated['penerbit'];
        $book->tahun_terbit = $validated['tahun_terbit'];
        $book->kategori = $validated['kategori'];
        $book->total_stock = $validated['total_stock'];
        $book->stock_available = $validated['total_stock'] - $book->loans()->where('status', 'Dipinjam')->count(); // Adjust stock available
        $book->deskripsi = $validated['deskripsi'];
        $book->ratings = $validated['ratings'];

        // Handle artikel file update
        if ($request->hasFile('artikel')) {
            $artikelFile = $request->file('artikel');
            $artikelFileName = time() . '.' . $artikelFile->getClientOriginalExtension();
            $artikelFile->storeAs('public/artikels', $artikelFileName); // Store file in storage directory

            // Delete old artikel file if exists
            if ($book->artikel) {
                Storage::delete('public/' . $book->artikel);
            }

            $book->artikel = 'artikels/' . $artikelFileName; // Store relative path to the PDF file
        }

        // Handle cover image update
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverFileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $coverFileName); // Store file in storage directory

            // Delete old cover file if exists
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }

            $book->cover = 'covers/' . $coverFileName; // Store relative path to the image
        }

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
}
