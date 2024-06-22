<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
            'roles' => $request->roles,
            'jenis_kelamin' => $request->jenis_kelamin,
            'photo_profile' => $photoPath,
        ]);

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
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'required',
            'nomor_telpon' => 'required',
            'roles' => 'nullable',
            'jenis_kelamin' => 'required',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle password update
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required',
            ]);
            $user->password = Hash::make($request->password);
        }

        $photoPath = $user->photo_profile;
        if ($request->hasFile('photo_profile')) {
            $photo = $request->file('photo_profile');
            $fileName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/photo_profiles', $fileName); // Store file in storage directory
            $photoPath = 'photo_profiles/' . $fileName; // Store relative path to the photo profile
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon,
            'roles' => $request->roles,
            'jenis_kelamin' => $request->jenis_kelamin,
            'photo_profile' => $photoPath,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
