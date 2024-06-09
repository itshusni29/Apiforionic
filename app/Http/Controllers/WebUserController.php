<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'email' => 'required|email',
            'password' => 'required',
            'alamat' => 'required',
            'nomor_telpon' => 'required',
            'roles' => 'nullable',
            'jenis_kelamin' => 'required',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'nomor_telpon' => 'required',
            'roles' => 'nullable',
            'jenis_kelamin' => 'required',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika input password kosong, gunakan password lama
        if ($request->has('password') && $request->password !== null) {
            $request->validate([
                'password' => 'required',
            ]);
            $password = bcrypt($request->password);
        } else {
            $password = $user->password;
        }

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,    
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon,
            'roles' => $request->roles,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        // Penanganan foto profil
        if ($request->hasFile('photo_profile')) {
            $photo = $request->file('photo_profile');
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/photo_profiles', $fileName); // Simpan file di direktori storage
            $user->photo_profile = 'photo_profiles/' . $fileName; // Simpan path relatif ke foto profil
            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
