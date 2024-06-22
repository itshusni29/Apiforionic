<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)  
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
                            $fail($attribute.' harus mengandung setidaknya satu huruf besar, satu angka, dan satu simbol.');
                        }
                    },
                ],
                'alamat' => 'required|string',
                'nomor_telpon' => 'required|string',
                'jenis_kelamin' => 'required|string|in:L,P',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        if ($user) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token], 201);
        } else {
            return response()->json(['message' => 'User registration failed'], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function refresh()
    {
        $token = JWTAuth::refresh();
        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response()->json(['message' => 'Logout successful']);
    }
}
