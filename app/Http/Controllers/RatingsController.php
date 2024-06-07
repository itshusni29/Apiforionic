<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Book;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function index()
    {
        return Rating::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $userId = auth()->id();
        $bookId = $request->book_id;

        // Check if the rating already exists
        $existingRating = Rating::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($existingRating) {
            // If rating exists, update it
            $existingRating->update([
                'rating' => $request->rating,
            ]);

            $this->updateBookAverageRating($bookId);

            return response()->json($existingRating, 200);
        }

        // If no existing rating, create a new one
        $rating = Rating::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'rating' => $request->rating,
        ]);

        $this->updateBookAverageRating($bookId);

        return response()->json($rating, 201);
    }

    public function show($id)
    {
        return Rating::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $rating = Rating::findOrFail($id);

        // Check if the authenticated user is the owner of the rating
        if ($rating->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $rating->update($request->only('rating'));

        $this->updateBookAverageRating($rating->book_id);

        return response()->json($rating, 200);
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        // Check if the authenticated user is the owner of the rating
        if ($rating->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $bookId = $rating->book_id;

        $rating->delete();

        $this->updateBookAverageRating($bookId);

        return response()->json(null, 204);
    }

    private function updateBookAverageRating($bookId)
    {
        $book = Book::findOrFail($bookId);
        $averageRating = $book->calculateAverageRating();
        $book->ratings = $averageRating;
        $book->save();
    }
}
