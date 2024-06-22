<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/[A-Z]/', $value) || !preg_match('/[0-9]/', $value) || !preg_match('/[^A-Za-z0-9]/', $value)) {
                            $fail($attribute.' must contain at least one uppercase letter, one number, and one symbol.');
                        }
                    },
                ],
                'alamat' => 'required|string',
                'nomor_telpon' => 'required|string',
                'jenis_kelamin' => 'required|string|in:L,P',
                'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $photoPath = null;
        if ($request->hasFile('photo_profile')) {
            $photo = $request->file('photo_profile');
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/photo_profiles', $fileName); // Store file in storage directory
            $photoPath = 'photo_profiles/' . $fileName; // Store relative path to the photo profile
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'photo_profile' => $photoPath,
        ]);

        if ($user) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token], 201);
        } else {
            return response()->json(['message' => 'User registration failed'], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        // Ensure only the authenticated user can update their own details
        $loggedInUser = auth()->user();
        if ($loggedInUser->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $request->validate([
                'name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'alamat' => 'sometimes|required|string',
                'nomor_telpon' => 'sometimes|required|string',
                'jenis_kelamin' => 'sometimes|required|string|in:L,P',
                'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        if ($request->hasFile('photo_profile')) {
            // Delete previous photo if exists
            if ($user->photo_profile) {
                Storage::delete('public/' . $user->photo_profile);
            }

            // Upload new photo
            $photo = $request->file('photo_profile');
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/photo_profiles', $fileName); // Store file in storage directory
            $user->photo_profile = 'photo_profiles/' . $fileName; // Update the photo profile path
        }

        // Update fields only if present in the request
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('alamat')) {
            $user->alamat = $request->alamat;
        }
        if ($request->filled('nomor_telpon')) {
            $user->nomor_telpon = $request->nomor_telpon;
        }
        if ($request->filled('jenis_kelamin')) {
            $user->jenis_kelamin = $request->jenis_kelamin;
        }

        $user->save();  

        return response()->json(['user' => $user], 200);
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user], 200);
    }

    public function destroy(User $user)
    {
        // Check if the authenticated user is admin
        if (auth()->user()->roles !== 'admin') {
            return response()->json(['message' => 'Forbidden, Admin access only'], 403);
        }

        try {
            $userName = $user->name; // Get the name of the user being deleted
            
            // Attempt to delete the user
            $user->delete();

            return response()->json(['message' => "User '{$userName}' has been deleted successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user', 'error' => $e->getMessage()], 500);
        }
    }
}
