<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
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

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        $book->judul = $validated['judul'];
        $book->pengarang = $validated['pengarang'];
        $book->penerbit = $validated['penerbit'];
        $book->tahun_terbit = $validated['tahun_terbit'];
        $book->kategori = $validated['kategori'];
        $book->total_stock = $validated['total_stock'];
        $book->stock_available = $validated['total_stock']; // Set initial available stock to total stock
        $book->deskripsi = $validated['deskripsi'];
        $book->ratings = $validated['ratings'];

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $fileName); // Store file in storage directory
            $book->cover = 'covers/' . $fileName; // Store relative path to the image
        }

        $book->save();

        return response()->json(['message' => 'Book created successfully'], 201);
    }

    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->cover) {
            $book->cover = asset('storage/' . $book->cover);
        }

        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
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

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = time() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public/covers', $fileName); // Store file in storage directory
            // Delete old cover file if exists
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }
            $book->cover = 'covers/' . $fileName;
        }

        $book->save();

        return response()->json(['message' => 'Book updated successfully'], 200);
    }

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
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }

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
        }

        return response()->json($books);
    }
}
