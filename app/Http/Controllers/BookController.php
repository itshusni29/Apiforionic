<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
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
        $book->stock_available = $request->total_stock; // Set initial available stock to total stock
        $book->deskripsi = $request->deskripsi;
        $book->ratings = $request->ratings;

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
        if ($book) {
            // Check if cover image exists
            if ($book->cover) {
                // Generate full URL for the cover image
                $book->cover = asset('storage/' . $book->cover);
            } else {
                // If cover image doesn't exist, set it to null or an empty string
                $book->cover = null; // or ''
            }
            return response()->json($book);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
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
        if ($book) {
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

            return response()->json(['message' => 'Book updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if ($book) {
            // Hapus file cover jika ada sebelum menghapus buku
            if ($book->cover) {
                Storage::delete('public/' . $book->cover);
            }
            $book->delete();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }
}
?>
