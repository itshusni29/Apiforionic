<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookLoanHistory;
use Illuminate\Support\Facades\Auth;

class BookLoanHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $loanHistory = BookLoanHistory::where('user_id', $user->id)->with('book', 'bookLoan')->get();
        return response()->json($loanHistory);
    }
}
?>
