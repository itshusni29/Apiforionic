<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'alamat' => 'required',
            'nomor_telpon' => 'required',
            'roles' => 'nullable',
            'jenis_kelamin' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon,
            'roles' => $request->roles,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        // Menghitung informasi peminjaman buku
        $totalBooksBorrowed = BookLoan::where('user_id', $user->id)
                                      ->where('status', 'Dipinjam')
                                      ->count();

        $totalBooksReturned = BookLoan::where('user_id', $user->id)
                                      ->where('status', 'Dikembalikan')
                                      ->count();

        $currentBooksBorrowed = $totalBooksBorrowed - $totalBooksReturned;

        return view('users.show', compact('user', 'totalBooksBorrowed', 'totalBooksReturned', 'currentBooksBorrowed'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'required',
            'nomor_telpon' => 'required',
            'roles' => 'nullable',
            'jenis_kelamin' => 'required',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon,
            'roles' => $request->roles,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
