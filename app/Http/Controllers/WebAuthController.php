<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Jika berhasil login, redirect ke halaman home
            return redirect()->intended('/'); 
        }
    
        // Jika gagal, kembali ke halaman login dengan pesan error
        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.'])->withInput($request->only('email'));
    }
    

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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
        ]);

        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Otomatis login setelah registrasi
        Auth::attempt($request->only('email', 'password'));

        // Redirect ke halaman setelah login
        return redirect('/dashboard'); // Ganti '/dashboard' dengan halaman yang ingin dituju setelah registrasi berhasil
    }

    // Method untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
