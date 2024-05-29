<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Wishlist::with('book')->where('user_id', $user->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();

        // Check if the book is already in the wishlist
        $existingWishlistItem = Wishlist::where('user_id', $user->id)
                                        ->where('book_id', $request->book_id)
                                        ->first();
        if ($existingWishlistItem) {
            return response()->json(['message' => 'Book is already in the wishlist'], 400);
        }

        $wishlist = new Wishlist();
        $wishlist->user_id = $user->id;
        $wishlist->book_id = $request->book_id;
        $wishlist->save();

        return response()->json(['message' => 'Book added to wishlist successfully'], 201);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('book_id', $id)
                            ->first();
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['message' => 'Book removed from wishlist successfully'], 200);
        } else {
            return response()->json(['message' => 'Book not found in wishlist'], 404);
        }
    }
}
?>
