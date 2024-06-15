<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'alamat' => 'required',
            'nomor_telpon' => 'required',
            'roles' => 'nullable',
            'jenis_kelamin' => 'required|in:L,P', // Jenis kelamin hanya bisa 'L' atau 'P'
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload for photo_profile if exists
        if ($request->hasFile('photo_profile')) {
            $photoPath = $request->file('photo_profile')->store('public/photo_profiles');
            $photoUrl = url('/storage/' . str_replace('public/', '', $photoPath));
            $request->merge(['photo_profile' => $photoUrl]);
        }

        $user = User::create($request->all());

        return response()->json(['user' => $user], 201);
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request, User $user)
    {
        // Mengambil user yang sedang login
        $loggedInUser = auth()->user();

        // Memeriksa apakah yang mengedit adalah admin atau user yang sesuai
        if ($loggedInUser->isAdmin() || $loggedInUser->id === $user->id) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'alamat' => 'required',
                'nomor_telpon' => 'required',
                'roles' => 'nullable',
                'jenis_kelamin' => 'required|in:L,P',
                'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle file upload for photo_profile if exists
            if ($request->hasFile('photo_profile')) {
                $photoPath = $request->file('photo_profile')->store('public/photo_profiles');
                $photoUrl = url('/storage/' . str_replace('public/', '', $photoPath));
                $request->merge(['photo_profile' => $photoUrl]);
            }

            $user->update($request->all());

            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
